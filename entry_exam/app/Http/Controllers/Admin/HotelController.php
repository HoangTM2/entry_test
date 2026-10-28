<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\HotelSearchCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HotelSearchRequest;
use App\Http\Requests\Admin\HotelStoreRequest;
use App\Http\Requests\Admin\HotelUpdateRequest;
use App\Http\Resources\HotelResource;
use App\Repositories\Contracts\PrefectureRepositoryInterface;
use App\Services\HotelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    private const EDIT_SESSION_KEY = "hotel_edit_staged";

    public function __construct(
        private readonly HotelService $hotelService,
        private readonly PrefectureRepositoryInterface $prefectures,
    ) {
    }

    /** get methods */

    public function showSearch(): View
    {
        return view("admin.hotel.search", ["prefectures" => $this->prefectures->all()]);
    }

    public function showCreate(): View
    {
        return view("admin.hotel.create", ["prefectures" => $this->prefectures->all()]);
    }

    public function showEdit(Request $request): View|RedirectResponse
    {
        $hotelId = (int) $request->query("hotel_id");
        if ($hotelId <= 0) {
            return redirect()->route("adminHotelSearchPage");
        }

        try {
            $hotel = $this->hotelService->find($hotelId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return redirect()->route("adminHotelSearchPage")->with("status", "指定されたホテルが見つかりませんでした");
        }

        $isBack = $request->query("back") === "1";
        $staged = $request->session()->get(self::EDIT_SESSION_KEY);

        // Restore input only when explicitly returning from the confirmation screen via "戻る" button.
        // Otherwise (fresh visit from list or page refresh), discard staged edits and load fresh from DB.
        if ($isBack && $staged && (int) $staged["hotel_id"] === $hotel->hotel_id) {
            $input = $staged;
        } else {
            if ($staged) {
                $this->hotelService->discardStaged($staged);
                $request->session()->forget(self::EDIT_SESSION_KEY);
            }
            $input = [
                "hotel_name" => $hotel->hotel_name,
                "prefecture_id" => $hotel->prefecture_id,
            ];
        }

        return view("admin.hotel.edit", [
            "hotel" => (new HotelResource($hotel))->resolve(),
            "input" => $input,
            "prefectures" => $this->prefectures->all(),
        ]);
    }

    public function showEditComplete(): View
    {
        return view("admin.hotel.edit_complete");
    }

    /** post methods */

    public function searchResult(HotelSearchRequest $request): View
    {
        $criteria = new HotelSearchCriteria(
            $request->filled("hotel_name") ? $request->string("hotel_name")->toString() : null,
            $request->filled("prefecture_id") ? $request->integer("prefecture_id") : null,
        );

        return view("admin.hotel.result", [
            "hotelList" => HotelResource::collection($this->hotelService->search($criteria))->resolve(),
            "prefectures" => $this->prefectures->all(),
        ]);
    }

    public function create(HotelStoreRequest $request): RedirectResponse
    {
        $this->hotelService->create(
            $request->string("hotel_name")->toString(),
            $request->integer("prefecture_id"),
            $request->file("image"),
        );

        return redirect()->route("adminHotelCreatePage")->with("status", "ホテルを追加しました");
    }

    /**
     * Edit step 2: confirmation screen.
     */
    public function editConfirm(HotelUpdateRequest $request): View
    {
        $staged = $this->hotelService->stageUpdate(
            $request->string("hotel_name")->toString(),
            $request->integer("prefecture_id"),
            $request->file("image"),
            $request->session()->get(self::EDIT_SESSION_KEY),
            $request->input("existing_temp_image"),
        );
        $staged["hotel_id"] = $request->integer("hotel_id");
        $request->session()->put(self::EDIT_SESSION_KEY, $staged);

        $hotel = $this->hotelService->find($staged["hotel_id"]);
        $prefecture = $this->prefectures->all()->firstWhere("prefecture_id", $staged["prefecture_id"]);

        return view("admin.hotel.edit_confirm", [
            "hotel" => (new HotelResource($hotel))->resolve(),
            "staged" => $staged,
            "prefectureName" => $prefecture?->prefecture_name,
            "tempImageUrl" => $staged["temp_image"] ? asset("assets/img/" . $staged["temp_image"]) : null,
        ]);
    }

    /**
     * Edit step 3: persist and redirect to the completion screen.
     */
    public function edit(Request $request): RedirectResponse
    {
        $staged = $request->session()->pull(self::EDIT_SESSION_KEY);

        if (!$staged) {
            return redirect()->route("adminHotelSearchPage");
        }

        $this->hotelService->commitUpdate((int) $staged["hotel_id"], $staged);

        return redirect()->route("adminHotelEditCompletePage");
    }

    public function delete(Request $request): RedirectResponse
    {
        $hotelId = (int) $request->input("hotel_id");
        if ($hotelId <= 0) {
            return redirect()->route("adminHotelSearchPage");
        }

        try {
            $this->hotelService->delete($hotelId);
            $message = "ホテルを削除しました";
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            $message = "指定されたホテルが見つかりませんでした";
        }

        return redirect()->route("adminHotelSearchPage")->with("status", $message);
    }
}
