@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('cards.update', ['deck' => $deck->id, 'card' => $card->id]) }}" method="POST" class="custom-form">
            @csrf
            @method('PUT') {{-- PUTメソッドで更新リクエストを送信するためのフィールド --}}
            
            <div class="form-group">
                <label for="front">表面</label>
                <input type="text" name="front" id="front" class="form-control input-custom" value="{{ old('front', $card->front) }}" required>
            </div>
            <div class="form-group">
                <label for="back">裏面</label>
                <input type="text" name="back" id="back" class="form-control input-custom" value="{{ old('back', $card->back) }}" required>
            </div>
            
            <button type="submit" class="create-button">保存</button>
            <a href="{{ route('decks.show', $deck->id) }}" class="btn btn-secondary">デッキ編集画面へ戻る</a>
        </form>
    </div>
@endsection
