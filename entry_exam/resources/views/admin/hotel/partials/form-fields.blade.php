<div class="form-row">
    <label for="hotel_name">ホテル名</label>
    <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $input['hotel_name'] ?? '') }}">
    @error('hotel_name')<p class="error-message">{{ $message }}</p>@enderror
</div>
<div class="form-row">
    <label for="prefecture_id">都道府県</label>
    <select id="prefecture_id" name="prefecture_id">
        <option value="">選択してください</option>
        @foreach ($prefectures as $prefecture)
            <option value="{{ $prefecture->prefecture_id }}" @selected((string) old('prefecture_id', $input['prefecture_id'] ?? '') === (string) $prefecture->prefecture_id)>
                {{ $prefecture->prefecture_name }}
            </option>
        @endforeach
    </select>
    @error('prefecture_id')<p class="error-message">{{ $message }}</p>@enderror
</div>
<div class="form-row">
    <label for="image">ホテル画像 (任意)</label>
    <input type="file" id="image" name="image" accept="image/png,image/jpeg">
    @error('image')<p class="error-message">{{ $message }}</p>@enderror
</div>
