<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>デッキ一覧</title>
</head>
<body>
<h1>デッキ一覧</h1>

<!-- 検索フォーム -->
<form method="GET" action="{{ route('decks.index') }}">
    <input type="text" name="search" placeholder="デッキ名で検索" value="{{ request('search') }}">
    <button type="submit">検索</button>
</form>

<!-- デッキ一覧 -->
<table border="1">
    <thead>
    <tr>
        <th>デッキ名</th>
        <th>アクション</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($decks as $deck)
        <tr>
            <td>{{ $deck->name }}</td>
            <td>
                <a href="#">学習開始</a>
                <a href="#">カード編集</a>
                <a href="{{ route('decks.edit', $deck->id) }}">デッキ名変更</a>
                <form action="{{ route('decks.destroy', $deck->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- 新規作成ボタン -->
<a href="{{ route('decks.create') }}">新規作成</a>
</body>
</html>
