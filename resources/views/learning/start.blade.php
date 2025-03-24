@extends('layouts.app')

@section('content')
<div class="container mx-auto my-6">
    <div class="flashcard bg-white p-6 rounded-lg shadow-lg">
        <!-- 学習進捗表示 -->
        <div class="progress mb-4 text-center">
        <p class="text-lg" id="progress-text"></p>
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
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById('toggle-button');
        const cardFront = document.getElementById('card-front');
        const cardBack = document.getElementById('card-back');
        const nextCardButton = document.getElementById('nextCardButton');
        const completionMessage = document.getElementById('completion-message');
        const flashcard = document.querySelector('.flashcard');
        const progressText = document.getElementById('progress-text');

        let currentCardIndex = {{ $currentCardIndex }};
        const totalCards = {{ count($cards) }};
        const deckId = {{ $deck->id }};

        // 初期表示を設定
        updateProgress();

        toggleButton.addEventListener('click', function () {
            cardFront.style.display = cardFront.style.display === 'none' ? 'block' : 'none';
            cardBack.style.display = cardBack.style.display === 'none' ? 'block' : 'none';
            toggleButton.textContent = cardFront.style.display === 'none' ? '表面を表示' : '裏面を表示';
        });

        nextCardButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (currentCardIndex >= totalCards - 1) {
                flashcard.style.display = 'none';
                completionMessage.style.display = 'block';
                return;
            }

            fetch(`/learning/next/${deckId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ currentCardIndex })
            })
            .then(response => response.json())
            .then(data => {
                if (data.completed) {
                    flashcard.style.display = 'none';
                    completionMessage.style.display = 'block';
                } else {
                    currentCardIndex = data.currentCardIndex;
                    cardFront.innerHTML = `<p class="text-xl">${data.front}</p>`;
                    cardBack.innerHTML = `<p class="text-xl">${data.back}</p>`;
                    cardBack.style.display = 'none';
                    cardFront.style.display = 'block';
                    toggleButton.textContent = '裏面を表示';

                    // 進捗表示を更新
                    updateProgress();
                }
            })
            .catch(error => console.error('エラー:', error));
        });

        function updateProgress() {
            progressText.textContent = `${currentCardIndex + 1} / ${totalCards} 枚目`;
        }
    });
</script>


@endsection
