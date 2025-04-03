@extends('layouts.app')

@section('content')
<!-- 新規作成ボタン -->
<a href="{{ route('decks.create') }}" class="create-button">
デッキの新規作成
</a>

<!-- 検索フォーム -->
<div class="search-container">
<form action="{{ route('decks.index') }}" method="GET">
    <input type="text" name="search" placeholder="デッキ名を検索" value="{{ request('search') }}" class="search-input">
    <button type="submit" class="search-button">検索</button>
</form>
</div>


<!-- デッキ一覧 -->
<table border="1" class="decks-table">
    <thead>
    </thead>
    <tbody>
    @foreach ($decks as $deck)
        <tr>
            <td>{{ $deck->name }}</td>
            <td>
                <a href="{{ route('learning.start', ['deck' => $deck->id]) }}">学習開始</a>
                <a href="{{ route('decks.show', $deck->id) }}">デッキ編集</a>
                <a href="{{ route('decks.edit', $deck->id) }}">デッキ名変更</a>
                <form action="{{ route('decks.destroy', $deck->id) }}" method="POST" class="delete-form" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">削除</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>
@endsection
