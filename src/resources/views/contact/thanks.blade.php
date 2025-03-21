@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks-container">
    <p class="thanks-message">お問い合わせありがとうございます</p>
    {{-- HOMEボタン --}}
    <a href="{{ route('contact.index') }}" class="home-button">HOME</a>
</div>
@endsection