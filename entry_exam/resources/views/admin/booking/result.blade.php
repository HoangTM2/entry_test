@extends('admin.booking.search')

@section('search_results')
    <div class="page-wrapper search-page-wrapper">
        <div class="search-result">
            <h3 class="search-result-title">検索結果</h3>
            @if (!empty($bookings))
                <table class="shopsearchlist_table">
                    <tbody>
                        <tr>
                            <td nowrap>顧客名</td>
                            <td nowrap>顧客連絡先</td>
                            <td nowrap>チェックイン日時</td>
                            <td nowrap>チェックアウト日時</td>
                            <td nowrap>予約日時</td>
                            <td nowrap>情報更新日時</td>
                        </tr>
                        @foreach ($bookings as $booking)
                            <tr style="background-color:#BDF1FF">
                                <td>{{ $booking['customer_name'] }}</td>
                                <td>{{ $booking['customer_contact'] }}</td>
                                <td>{{ $booking['chekin_time'] }}</td>
                                <td>{{ $booking['checkout_time'] }}</td>
                                <td>{{ $booking['created_at'] }}</td>
                                <td>{{ $booking['updated_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>検索結果がありません</p>
            @endif
        </div>
    </div>
@endsection
