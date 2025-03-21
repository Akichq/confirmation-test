{{-- モーダルの中身 --}}
<div id="modal-content" class="modal">
    <h1>お問い合わせ詳細</h1>

        <p><strong>ID:</strong> {{ $contact->id }}</p>
        <p><strong>お名前:</strong>{{ $contact->last_name}} {{$contact->first_name}}</p>
        <p><strong>性別:</strong>
            @if ($contact->gender === 1)
            男性
            @elseif ($contact->gender === 2)
            女性
            @else
            その他
            @endif</p>
        <p><strong>メールアドレス:</strong> {{ $contact->email }}</p>
        <p><strong>電話番号:</strong> {{ $contact->tel }}</p>
        <p><strong>住所:</strong> {{ $contact->address }}</p>
        <p><strong>建物名:</strong> {{ $contact->building ?? '（なし）' }}</p>
        <p><strong>お問い合わせの種類:</strong> {{ $contact->category->content }}</p>
        <p><strong>お問い合わせ内容:</strong> {{ $contact->detail }}</p>
        <p><strong>作成日時:</strong> {{ $contact->created_at }}</p>
        <p><strong>更新日時:</strong> {{ $contact->updated_at }}</p>

    <div class="button-group">
        <form action="{{ route('admin.destroy', ['id' => $contact->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button" onclick="return confirm('本当に削除しますか？');">削除</button>
        </form>
    </div>

    <a href="#" rel="modal:close">×</a> {{-- 閉じるボタン --}}
</div>