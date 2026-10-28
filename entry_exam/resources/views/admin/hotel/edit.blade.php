@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/form.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper form-page">
        <h2 class="title">ホテル編集 (1/3 入力)</h2>
        <hr>
        <form action="{{ route('adminHotelEditConfirm') }}" method="post" enctype="multipart/form-data" class="hotel-form">
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $hotel['hotel_id'] }}">
            @if ($hotel['image_url'])
                <div class="form-row">
                    <label>現在の画像</label>
                    <img src="{{ $hotel['image_url'] }}" alt="{{ $hotel['hotel_name'] }}" class="preview-image">
                </div>
            @endif
            @if (!empty($input['temp_image']))
                <input type="hidden" name="existing_temp_image" value="{{ $input['temp_image'] }}">
                <div class="form-row">
                    <label>選択中の新しい画像</label>
                    <img src="{{ asset('assets/img/' . $input['temp_image']) }}" alt="temp image" class="preview-image">
                </div>
            @endif
            @include('admin.hotel.partials.form-fields')
            <button type="submit">確認画面へ</button>
        </form>
    </div>
@endsection
