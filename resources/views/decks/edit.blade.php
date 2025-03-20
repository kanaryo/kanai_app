
    <h1>デッキの編集</h1>

    <form action="{{ route('decks.update', $deck->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- 更新のために PUT メソッドを使用 -->

        <label for="name">デッキ名:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $deck->name) }}" required>

        <button type="submit">更新</button>
        <a href="{{ route('decks.index') }}">キャンセル</a>
    </form>
