<?php
// app/Http/Controllers/CardController.php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * 新規カード登録画面の表示
     */
    public function create($deckId)
    {
        $deck = Deck::findOrFail($deckId);
        return view('cards.create', compact('deck'));
    }

    // カードの新規作成
    public function store(Request $request, $deckId)
    {
        $request->validate([
            'front' => 'required|max:255',
            'back' => 'required|max:255',
        ]);

        Card::create([
            'deck_id' => $deckId,
            'front' => $request->front,
            'back' => $request->back,
        ]);
        return redirect()->route('cards.create', $deckId)->with('success', 'カードが作成されました');
    }

    // カード更新画面の表示
    public function edit($deckId, $cardId)
    {
        $deck = Deck::findOrFail($deckId);
        $card = Card::findOrFail($cardId);
        return view('cards.edit', compact('deck', 'card'));
    }

    // 更新処理
    public function update(Request $request, $deckId, $cardId)
    {
        $request->validate([
            'front' => 'required|max:255',
            'back' => 'required|max:255',
        ]);

        $card = Card::findOrFail($cardId);
        $card->update([
            'front' => $request->front,
            'back' => $request->back,
        ]);

        return redirect()->route('cards.edit', ['deck' => $deckId, 'card' => $cardId]);
    }

    //カードの削除処理
    public function destroy($deckId, $cardId)
{
    // カードを取得し、削除する
    $card = Card::findOrFail($cardId);
    $card->delete();

    // 削除後は、デッキ詳細画面にリダイレクト
    return redirect()->route('decks.show', $deckId)->with('success', 'カードが削除されました');
}
}
