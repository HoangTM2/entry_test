@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/form.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper form-page">
        <h2 class="title">ホテル編集 (2/3 確認)</h2>
        <hr>
        <dl class="confirm-list">
            <dt>ホテル名</dt><dd>{{ $staged['hotel_name'] }}</dd>
            <dt>都道府県</dt><dd>{{ $prefectureName }}</dd>
            <dt>ホテル画像</dt>
            <dd>
                @if ($tempImageUrl)
                    <img src="{{ $tempImageUrl }}" alt="new image" class="preview-image">
                @elseif ($hotel['image_url'])
                    <img src="{{ $hotel['image_url'] }}" alt="current image" class="preview-image">
                @else
                    なし
                @endif
            </dd>
        </dl>
        <div class="confirm-actions">
            <form action="{{ route('adminHotelEditPage') }}" method="get">
                <input type="hidden" name="hotel_id" value="{{ $hotel['hotel_id'] }}">
                <input type="hidden" name="back" value="1">
                <button type="submit">戻る</button>
            </form>
            <form action="{{ route('adminHotelEditProcess') }}" method="post">
                @csrf
                <button type="submit">更新する</button>
            </form>
        </div>
    </div>
@endsection
