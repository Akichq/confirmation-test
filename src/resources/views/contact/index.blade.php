@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-container">
    <h1 class="contact-title">Contact</h1>
    <form class="contact-form" action="{{ route('contact.confirm') }}" method="post">
        @csrf

        <!-- 姓 -->
        <div class="form-group">
            <label for="first_name" class="form-label">姓<span class="required-label">※</span></label>
            <input type="text" name="first_name" id="first_name" class="form-input" placeholder="例: 山田" value="{{ old('first_name') }}">
            @error('first_name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 名 -->
        <div class="form-group">
            <label for="last_name" class="form-label">名<span class="required-label">※</span></label>
            <input type="text" name="last_name" id="last_name" class="form-input" placeholder="例: 太郎" value="{{ old('last_name') }}">
            @error('last_name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 性別 -->
        <div class="form-group">
            <label class="form-label">性別<span class="required-label">※</span></label>
            <div class="gender-inputs">
                {{-- デフォルトで男性を選択 --}}
                <input type="radio" name="gender" id="male" value="1" class="form-input-radio" {{ old('gender', 1) == '1' ? 'checked' : '' }}>
                <label for="male" class="form-input-radio-label">男性</label>

                <input type="radio" name="gender" id="female" value="2" class="form-input-radio" {{ old('gender') == '2' ? 'checked' : '' }}>
                <label for="female" class="form-input-radio-label">女性</label>

                <input type="radio" name="gender" id="other" value="3" class="form-input-radio" {{ old('gender') == '3' ? 'checked' : '' }}>
                <label for="other" class="form-input-radio-label">その他</label>
            </div>
            @error('gender')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- メールアドレス -->
        <div class="form-group">
            <label for="email" class="form-label">メールアドレス<span class="required-label">※</span></label>
            <input type="email" name="email" id="email" class="form-input" placeholder="例: test@example.com" value="{{ old('email') }}">
            @error('email')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 電話番号 -->
        <div class="form-group">
            <label for="tel" class="form-label">電話番号<span class="required-label">※</span></label>
            <input type="tel" name="tel" id="tel" class="form-input" placeholder="例: 09012345678" value="{{ old('tel') }}">
            @error('tel')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="address" class="form-label">住所<span class="required-label">※</span></label>
            <input type="text" name="address" id="address" class="form-input" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
            @error('address')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" name="building" id="building" class="form-input" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
            @error('building')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- お問い合わせの種類 -->
        <div class="form-group">
            <label for="category_id" class="form-label">お問い合わせの種類<span class="required-label">※</span></label>
            <select name="category_id" id="category_id" class="form-select">
                {{-- デフォルトで「選択してください」を表示 --}}
                <option value="">選択してください</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- お問い合わせ内容 -->
        <div class="form-group">
            <label for="detail" class="form-label">お問い合わせ内容<span class="required-label">※</span></label>
            <textarea name="detail" id="detail" class="form-textarea" placeholder="お問い合わせ内容をご記載ください" maxlength="120">{{ old('detail') }}</textarea>
            @error('detail')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- 確認ボタン -->
        <button type="submit" class="confirm-button">確認画面</button>
    </form>
</div>
@endsection