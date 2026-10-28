@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/form.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper form-page">
        <h2 class="title">ホテル追加</h2>
        <hr>
        @if (session('status'))
            <p class="status-message">{{ session('status') }}</p>
        @endif
        <form action="{{ route('adminHotelCreateProcess') }}" method="post" enctype="multipart/form-data" class="hotel-form">
            @csrf
            @include('admin.hotel.partials.form-fields', ['input' => []])
            <button type="submit">追加</button>
        </form>
    </div>
@endsection
