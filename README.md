## Entrance Exam for THK Holdings Vietnam in Hanoi

Welcome to THK Holdings Vietnam in Hanoi!!
Thank you for applying to us!

## About this exam

In this exam, you implement for these following fields using a Laravel application.
There are required and optional field to implement.

If you implement optional field, we consider your extra technical skills.

We will use Laravel Sail to build this exam environment.
Laravel Sail is a Laravel library that allows you to build an environment using virtualization container software called docker just by typing a command.
For more information about Laravel Sail, please refer to [the official Laravel documentation](https://readouble.com/laravel/11.x/en/sail.html).

### Application's information

[view](document/INFORMATION.md)

### Implementation fields

[view](document/IMPLEMENTATION_FIELD.md)

### Notice

- You write some comments as optional. But if you do, please write in Japanese or English.
- The design (CSS style) is up to you. Please use SCSS as possible.
- If there is unclear stated and specification, you implement the best for you.
- We will consider for the selection process from all of your implemented contents.
- Even if you couldn't complete all items, no problem. We will consider only your implemented scope. So please submit it by deadline.

### How to submit this exam

Please compress the `entry_test` folder into a zip file and submit it via email.
To reduce data size, please delete the `entry_exam/node_modules` folder and `entry_exam/vendor` folder along with all files under them before compressing.

### Any comments (optional)

If you have any comments about this exam, please write them down here.
```
【実装の概要 / Overview of Implementation】

1. 必須要件 (Required Fields):
   - ホテル新規登録機能 (Hotel creation):
     - Form Request によるバリデーション、画像アップロード (public/assets/img/hotel への保存) を実装。
   - ホテル編集機能 (Hotel editing):
     - 3段階画面遷移 (1. 入力画面 -> 2. 確認画面 -> 3. 完了画面) を実装。
     - 確認画面での新画像プレビュー、「戻る」時の入力保持、完了画面へのPRG遷移および物理ファイルの確定保存に対応。
   - ホテル削除機能 (Hotel deletion):
     - JavaScript による削除確認ポップアップ (window.confirm) を実装。
     - 外部キー制約 (cascadeOnDelete) と画像ストレージの安全なクリーンアップに対応。
   - ホテル検索機能の改修・バグ修正 (Hotel search modifications):
     - 未入力検索時のエラーを修正し、フォーム直下に赤字で「何も入力されていません」と表示。
     - ホテル名の部分一致検索 (LIKE 検索, ワイルドカード文字のエスケープ処理) を実装。
     - 都道府県セレクトボックスによる絞り込み検索を追加。

2. 選択要件 (Optional Fields):
   - レスポンシブ対応 (Responsive design):
     - ユーザー画面および管理者画面について、SCSSメディアクエリによるスマートフォン・タブレット表示の最適化を実施。
   - 予約管理機能 (Hotel booking feature):
     - `bookings` テーブルのマイグレーションとシーダー (`BookingSeeder`) を作成。
     - 管理画面サイドメニューに「予約情報検索」リンクを追加。
     - 顧客名、顧客連絡先、チェックイン日時、チェックアウト日時での検索および検索結果一覧表示を実装。

3. 設計方針とアーキテクチャ (Architecture & Design Principles):
   - OOP & SOLID 原則に準拠したレイヤードアーキテクチャを採用:
     - Controller: HTTPリクエスト/レスポンスのハンドリングのみを担当。
     - FormRequest: バリデーションルールと日本語メッセージを集約。
     - Service 層 (`HotelService`, `BookingService`, `HotelImageStorage`): ビジネスロジックと画像管理の責務を分離。
     - Repository 層 (`EloquentHotelRepository`, `EloquentBookingRepository`, `EloquentPrefectureRepository`):
       インターフェース (`HotelRepositoryInterface` 等) を介して依存関係を逆転 (DIP) させ、テスタビリティと拡張性を向上。
     - DTO (`HotelSearchCriteria`, `BookingSearchCriteria`): 検索パラメータをイミュータブルにカプセル化。
     - Resource (`HotelResource`, `BookingResource`): プレゼンテーション層へのデータ変換を担当。
```

