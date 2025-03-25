@extends('layouts.app')

@section('content')

<div class="container mx-auto w-4/5 p-6 bg-white rounded-lg shadow-lg">

    <form action="{{ route('decks.update', $deck->id) }}" method="POST" class="custom-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name" class="block font-bold mb-2">デッキ名:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $deck->name) }}" required 
                class="input-custom w-full p-2 border border-gray-300 rounded">
        </div>

        <button type="submit" class="create-button">更新</button>
        <a href="{{ route('decks.index') }}" class="btn-secondary mt-4">デッキ一覧へ戻る</a>
    </form>
</div>
@endsection
