@extends('layouts.app')

@section('content')
<div class="container mx-auto my-6">
    <div class="flashcard bg-white p-6 rounded-lg shadow-lg">
        <!-- 学習進捗表示 -->
        <div class="progress mb-4 text-center">
            <p class="text-lg">{{ $currentCardIndex + 1 }} / {{ count($cards) }} 枚目</p>
        </div>

        <!-- 表面 -->
        <div class="card-face" id="card-front">
            <p class="text-xl">{{ $cards[$currentCardIndex]->front }}</p>
        </div>

        <!-- 裏面 (クリックで切り替え) -->
        <div class="card-face" id="card-back" style="display:none;">
            <p class="text-xl">{{ $cards[$currentCardIndex]->back }}</p>
        </div>

        <!-- 裏面表示トグル -->
        <button id="toggle-button" class="create-button mb-4">
            裏面を表示
        </button>

        <!-- 次のカードに進むボタン -->
        <form action="{{ route('learning.next', $deck->id) }}" method="POST" class="mb-4" id="nextCardForm">
            @csrf
            <input type="hidden" name="currentCardIndex" value="{{ $currentCardIndex }}">
            <button type="submit" id="nextCardButton" class="create-button">次のカードへ進む</button>
        </form>

        <!-- デッキ一覧へ戻る -->
        <a href="{{ route('decks.index') }}" class="btn-secondary">デッキ一覧へ戻る</a>
    </div>
    <!-- 完了メッセージ -->
    <div id="completion-message" style="display:none; margin-top: 20px;">
        <h3>お疲れ様でした！全てのカードを学習しました。</h3>
        <a href="{{ route('decks.index') }}" class="btn-secondary">デッキ一覧へ戻る</a>

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

    // 「次のカードへ進む」ボタンが押された時の処理
    const nextCardButton = document.getElementById('nextCardButton');
    const completionMessage = document.getElementById('completion-message');
    const nextCardForm = document.getElementById('nextCardForm');

    nextCardButton.addEventListener('click', function(e) {
        // 最後のカードの場合、フォーム送信を防止し、完了メッセージを表示する
        if ({{ $currentCardIndex }} === {{ count($cards) - 1 }}) {
            e.preventDefault();  // フォーム送信を防止
            // カードを非表示にする
            document.querySelector('.flashcard').style.display = 'none';
            // 完了メッセージを表示
            completionMessage.style.display = 'block';
        }
    });
</script>
@endsection
