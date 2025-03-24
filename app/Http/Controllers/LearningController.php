<?php
namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\Card;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    // 学習の開始
    public function start(Deck $deck)
    {
        // デッキに関連するカードを取得
        $cards = $deck->cards;

        return view('learning.start', [
            'deck' => $deck,
            'cards' => $cards,
            'currentCardIndex' => 0,  // 最初のカードから開始
        ]);
    }

    // 次のカードに進む
    public function next(Request $request, Deck $deck)
    {
        $currentCardIndex = $request->currentCardIndex;
        $cards = $deck->cards;
        $totalCards = count($cards);

        // 次のカードへ進む
        if ($currentCardIndex + 1 < $totalCards) {
            $currentCardIndex++;
        }

        // 学習完了の場合
        if ($currentCardIndex == $totalCards) {
            return view('learning.completed', ['deck' => $deck]);
        }

        return view('learning.start', [
            'deck' => $deck,
            'cards' => $cards,
            'currentCardIndex' => $currentCardIndex,
        ]);
    }
}
