@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flashcard">
        <!-- 学習進捗表示 -->
        <div class="progress">
            <p>{{ $currentCardIndex + 1 }} / {{ count($cards) }} 枚目</p>
        </div>

        <!-- 表面 -->
        <div class="card-face" id="card-front">
            <p>{{ $cards[$currentCardIndex]->front }}</p>
        </div>

        <!-- 裏面 (クリックで切り替え) -->
        <div class="card-face" id="card-back" style="display:none;">
            <p>{{ $cards[$currentCardIndex]->back }}</p>
        </div>

        <!-- 裏面表示トグル -->
        <button id="toggle-button">裏面を表示</button>

        <!-- 次のカードに進むボタン -->
        <form action="{{ route('learning.next', $deck->id) }}" method="POST">
            @csrf
            <input type="hidden" name="currentCardIndex" value="{{ $currentCardIndex }}">
            <button type="submit">次のカードへ進む</button>
        </form>

        <!-- デッキ一覧へ戻る -->
        <a href="{{ route('decks.index') }}" class="btn btn-secondary">デッキ一覧へ戻る</a>
    </div>
</div>

<script>
    // 表面と裏面の切り替え
    const toggleButton = document.getElementById('toggle-button');
    const cardFront = document.getElementById('card-front');
    const cardBack = document.getElementById('card-back');

    toggleButton.addEventListener('click', function () {
        cardFront.style.display = cardFront.style.display === 'none' ? 'block' : 'none';
        cardBack.style.display = cardBack.style.display === 'none' ? 'block' : 'none';
        toggleButton.textContent = cardFront.style.display === 'none' ? '表面を表示' : '裏面を表示';
    });
</script>
@endsection
