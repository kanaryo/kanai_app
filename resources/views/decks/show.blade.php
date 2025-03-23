@extends('layouts.app')

@section('content')
<!-- 新規作成ボタン -->
<a href="{{ route('cards.create', $deck->id) }}" class="create-button">新規カードの追加</a>

<!-- デッキ内カード一覧 -->
<h2>{{ $deck->name }} のカード一覧</h2>
<table border="1" class="decks-table">
    <thead>
        <tr>
            <th>表面</th>
            <th>裏面</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deck->cards as $card)
            <tr>
                <td>{{ $card->front }}</td>
                <td>{{ $card->back }}</td>
                <td>
                    <a href="{{ route('cards.edit', ['deck' => $deck->id, 'card' => $card->id]) }}">カード編集</a>
                    <form action="{{ route('cards.destroy', ['deck' => $deck->id, 'card' => $card->id]) }}" method="POST" class="delete-form" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">削除</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('decks.index') }}" class="btn btn-secondary">デッキ一覧画面へ戻る</a>

@endsection
