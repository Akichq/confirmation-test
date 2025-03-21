@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-container">
    <h1 class="title">Login</h1>
    <div class="form-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input"placeholder="例: test@example.com">
            @error('email')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required class="form-input"placeholder="例: coachtech1106">
            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
         <div class="button-container">
           <button type="submit" class="submit-button">ログイン</button>
        </div>
    </form>
    </div>
</div>
@endsection