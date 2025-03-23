<!-- <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>デッキ一覧</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delete-btn").click(function(event) {
            event.preventDefault(); // ボタンの通常の動作をキャンセル

            if (confirm("本当に削除しますか？")) {
                $(this).closest(".delete-form").submit(); // 確認OKならフォーム送信
            }
        });
    });
</script>
</head>
<body> -->
@extends('layouts.app')

@section('content')
<!-- 新規作成ボタン -->
<a href="{{ route('decks.create') }}" class="create-button">
新規作成
</a>


<!-- デッキ一覧 -->
<table border="1" class="decks-table">
    <thead>
    </thead>
    <tbody>
    @foreach ($decks as $deck)
        <tr>
            <td>{{ $deck->name }}</td>
            <td>
                <a href="#">学習開始</a>
                <a href="#">カード編集</a>
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
