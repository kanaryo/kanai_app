<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Deck; 

class DeckTest extends TestCase
{
    use RefreshDatabase; // テストごとにデータベースをリセット

    /** @test */
    public function DeckIsCreatedSuccessfully ()
    {
        // デッキを作成
        $deck = Deck::create(['name' => 'テストデッキ']);

        // データベースに保存されたか確認
        $this->assertDatabaseHas('decks', ['name' => 'テストデッキ']);
    }
}
