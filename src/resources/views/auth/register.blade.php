@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h1 class="title">Register</h1>
    <div class="form-container">
        <form method="POST" action="{{ route('register') }}"novalidate>
            @csrf

            <div class="form-group">
                <label for="name">お名前</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus class="form-input" placeholder="例: 山田 太郎">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="例: test@example.com">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" class="form-input" placeholder="例: coachtech1106">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-container">
                <button type="submit" class="submit-button">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
