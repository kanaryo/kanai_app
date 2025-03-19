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
            ->when($request->search, function($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();

        return view('decks.index', compact('decks'));
    }

    /**
     * デッキの新規登録
     *
     * @return View
     */
    public function create(): View
    {
        return view('decks.create');
    }

    /**
     * デッキの新規登録
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


}
