@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/form.scss')
    @vite('resources/scss/admin/booking.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">予約情報検索</h2>
        <hr>
        <div class="search-hotel-name search-booking-name">
            <form action="{{ route('adminBookingSearchResult') }}" method="post">
                @csrf
                <input type="text" name="customer_name" value="{{ old('customer_name', request('customer_name')) }}" placeholder="顧客名">
                <input type="text" name="customer_contact" value="{{ old('customer_contact', request('customer_contact')) }}" placeholder="顧客連絡先">
                <input type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" name="checkin_date" value="{{ old('checkin_date', request('checkin_date')) }}" placeholder="チェックイン日時">
                <input type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" name="checkout_date" value="{{ old('checkout_date', request('checkout_date')) }}" placeholder="チェックアウト日時">
                <button type="submit">検索</button>
                @foreach ($errors->all() as $error)
                    <p class="error-message">{{ $error }}</p>
                @endforeach
            </form>
        </div>
        <hr>
    </div>
    @yield('search_results')
@endsection
