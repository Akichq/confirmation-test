@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm-container">
    <h1 class="confirm-title">Confirm</h1>
    <form class="confirm-form" action="{{ route('contact.store') }}" method="post">
        @csrf

        <!-- 姓・名 -->
        <div class="form-group">
            <label class="form-label">お名前</label>
            <span class="form-value">{{ $contact['last_name'] }} {{ $contact['first_name'] }} </span>
            <input type="hidden" name="first_name" value="{{$contact['first_name']}}">
            <input type="hidden" name="last_name" value="{{$contact['last_name']}}">
        </div>

        <!-- 性別 -->
        <div class="form-group">
           <label class="form-label">性別</label>
             <span class="form-value"> @if($contact['gender'] == 1)
                男性
                @elseif($contact['gender'] == 2)
                女性
                @else
                その他
                @endif</span>
            <input type="hidden" name="gender" value="{{$contact['gender']}}">
       </div>

        <!-- メールアドレス -->
        <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <span class="form-value">{{ $contact['email'] }}</span>
            <input type="hidden" name="email" value="{{ $contact['email'] }}">
        </div>

        <!-- 電話番号 -->
        <div class="form-group">
           <label class="form-label">電話番号</label>
            <span class="form-value">{{ $contact['tel']}}</span>
           <input type="hidden" name="tel" value="{{$contact['tel']}}">
      </div>

        <!-- 住所 -->
        <div class="form-group">
            <label class="form-label">住所</label>
            <span class="form-value">{{ $contact['address'] }}</span>
            <input type="hidden" name="address" value="{{ $contact['address'] }}">
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label class="form-label">建物名</label>
             <span class="form-value">{{ $contact['building'] ?? '' }}</span>
            <input type="hidden" name="building" value="{{  $contact['building'] ?? '' }}">
       </div>

        <!-- お問い合わせの種類 -->
       <div class="form-group">
             <label class="form-label">お問い合わせの種類</label>
             <span class="form-value">{{ $category->content}}</span>
             <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
         </div>

        <!-- お問い合わせ内容 -->
        <div class="form-group">
            <label class="form-label">お問い合わせ内容</label>
            <span class="form-value">{{ $contact['detail'] }}</span>
            <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
        </div>

        <!-- 送信・修正ボタン -->
        <div class="button-group">
           <button type="submit" class="submit-button" name="action" value="submit">送信</button>
            {{-- 修正ボタン --}}
            <button type="submit" class="back-button" name="action" value="back">修正</button>
        </div>
    </form>
</div>
@endsection