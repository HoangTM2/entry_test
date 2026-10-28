<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\BookingSearchCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookingSearchRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function showSearch(): View
    {
        return view("admin.booking.search");
    }

    public function searchResult(BookingSearchRequest $request): View
    {
        $criteria = new BookingSearchCriteria(
            $request->filled("customer_name") ? $request->string("customer_name")->toString() : null,
            $request->filled("customer_contact") ? $request->string("customer_contact")->toString() : null,
            $request->filled("checkin_date") ? $request->string("checkin_date")->toString() : null,
            $request->filled("checkout_date") ? $request->string("checkout_date")->toString() : null,
        );

        $bookings = BookingResource::collection($this->bookingService->search($criteria))->resolve();

        return view("admin.booking.result", compact("bookings"));
    }
}
