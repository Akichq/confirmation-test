@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
    /* モーダルのスタイル */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 8px;
        position: relative;
    }

    .close-button {
        position: absolute; /* 修正 */
        top: 5px;
        right: 10px;
        font-size: 24px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .detail-link {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <h1>Admin</h1>
    <form action="{{ route('admin.search') }}" method="GET" class="search-form">
        <div class="search-form-row">
            <div class="search-input-group">
                <label for="name">名前</label>
                <input type="text" name="name" id="name" value="{{ request('name') }}">
            </div>
            <div class="search-input-group">
                <label for="gender">性別</label>
                <select name="gender" id="gender">
                    <option value="0" {{ request('gender') == '0' ? 'selected' : '' }}>全て</option>
                    <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="search-input-group">
                <label for="category_id">お問い合わせの種類</label>
                <select name="category_id" id="category_id">
                    <option value="0">全て</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="search-form-row">
            <div class="search-input-group">
                <label for="email">メールアドレス</label>
                <input type="text" name="email" id="email" value="{{ request('email') }}">
            </div>
            <div class="search-input-group">
                <label for="date_from">日付 (From)</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="search-input-group">
                <label for="date_to">日付 (To)</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
            </div>
        </div>
        <div class="search-buttons">
            <button type="submit" class="search-button">検索</button>
            <a href="{{ route('admin.index') }}" class="reset-button">リセット</a>
        </div>
    </form>
    <form action="{{ route('admin.export') }}" method="GET" class="export-form">
        @foreach(request()->all() as $key => $value)
        @if(!is_array($value))
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
        @endforeach
        <button type="submit" class="export-button">エクスポート</button>
    </form>
    <table class="contacts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th>詳細</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                <td>
                    @if($contact->gender == 1)
                    男性
                    @elseif($contact->gender == 2)
                    女性
                    @else
                    その他
                    @endif
                </td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->category->content }}</td>
                <td>
                    <a class="detail-link" data-modal-target="modal{{ $contact->id }}">詳細</a>
                </td>
                <td>
                    <form action="{{ route('admin.destroy', ['id' => $contact->id]) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button" onclick="return confirm('本当に削除しますか？');">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-links">
        {{ $contacts->appends(request()->query())->links() }}
    </div>
</div>
{{-- モーダルのコンテナ --}}
<div id="modal-container">
@foreach($contacts as $contact)
    <div id="modal{{$contact->id}}" class="modal">
        <div class="modal-content">
        <span class="close-button">×</span>
        <div id="modal-content-{{$contact->id}}"></div>
        </div>
    </div>
@endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const detailLinks = document.querySelectorAll('.detail-link');
        const modals = document.querySelectorAll('.modal');
        const closeButtons = document.querySelectorAll('.close-button');

        detailLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const targetId = this.dataset.modalTarget;
                const targetModal = document.getElementById(targetId);
                 const contactId = targetId.replace('modal', ''); // 'modal'を削除してIDを取得
                 // Ajaxで詳細データを取得
                 fetch(`/admin/show/${contactId}`) // APIのエンドポイントに合わせてください
                .then(response => response.json())
                .then(data => {
                    const modalContent = document.getElementById(`modal-content-${contactId}`);
                    modalContent.innerHTML = `
                        <p>ID: ${data.id}</p>
                        <p>お名前: ${data.last_name} ${data.first_name}</p>
                        <p>性別: ${data.gender === 1 ? '男性' : data.gender === 2 ? '女性' : 'その他'}</p>
                        <p>メールアドレス: ${data.email}</p>
                        <p>お問い合わせの種類: ${data.category.content}</p>
                        <p>お問い合わせ内容: ${data.opinion}</p>
                        <p>登録日時: ${data.created_at}</p>
                        `;
                })
                .catch(error => {
                    console.error('Error:', error);
                });

                if (targetModal) {
                    targetModal.style.display = 'block';
                }
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
    });
</script>
@endsection
