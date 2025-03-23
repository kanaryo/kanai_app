<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    /**
     * デッキの一覧表示
     *
     * @param Request $request
     * @return View|Factory|Application
     */
    public function index(Request $request): View|Factory|Application
    {
        $decks = Deck::query()
            ->where('delete_flag', false) // 削除されていないデータのみ取得
            ->when($request->search, function($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();

        return view('decks.index', compact('decks'));
    }

    /**
     * デッキの新規登録画面の表示
     *
     * @return View
     */
    public function create(): View
    {
        return view('decks.create');
    }

    /**
     * デッキの新規登録処理
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // データを保存
        Deck::create([
            'name' => $request->name,
        ]);

        // デッキ一覧ページにリダイレクト
        return redirect()->route('decks.create')->with('success', 'デッキを作成しました！');
    }

    /**
     * デッキ名の更新画面表示
     */
    public function edit(Deck $deck)
    {
        return view('decks.edit', compact('deck')); // デッキ情報をビューに渡す
    }

    /**
     * デッキ名の更新処理
     */
    public function update(Request $request, Deck $deck)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // デッキ情報の更新
        $deck->name = $request->input('name');
        $deck->save(); // 更新を保存

        return redirect()->route('decks.edit', $deck->id)->with('success', 'デッキが更新されました');
    }      

    /**
     * デッキの削除処理
     */
    public function destroy(Deck $deck)
    {
        // 論理削除の実行
        $deck->delete_flag = true; // もしくは適切な値に変更
        $deck->save();

        // リダイレクト処理
        return redirect()->route('decks.index')->with('success', 'デッキが削除されました');
    }


    /**
     * デッキ内カードの一覧表示画面
     */
    public function show($deckId)
    {
        $deck = Deck::with('cards')->findOrFail($deckId);
        return view('decks.show', compact('deck'));
    }
}
