<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
    @vite('resources/scss/admin/form.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">検索画面</h2>
        <hr>
        @if (session('status'))
            <p class="status-message">{{ session('status') }}</p>
        @endif
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelSearchResult') }}" method="post">
                @csrf
                <input type="text" name="hotel_name" value="{{ old('hotel_name', request('hotel_name')) }}" placeholder="ホテル名">
                <select name="prefecture_id">
                    <option value="">都道府県を選択</option>
                    @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}" @selected((string) old('prefecture_id', request('prefecture_id')) === (string) $prefecture->prefecture_id)>
                            {{ $prefecture->prefecture_name }}
                        </option>
                    @endforeach
                </select>
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
