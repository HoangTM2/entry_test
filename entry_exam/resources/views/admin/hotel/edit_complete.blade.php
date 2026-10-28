@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/form.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper form-page">
        <h2 class="title">ホテル編集 (3/3 完了)</h2>
        <hr>
        <p class="status-message">ホテル情報を更新しました</p>
        <a class="link" href="{{ route('adminHotelSearchPage') }}">検索画面へ戻る</a>
    </div>
@endsection
