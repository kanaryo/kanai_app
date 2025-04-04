@extends('layouts.app')

@section('content')
<h1 class="form-title">新規デッキ作成</h1>
<form action="{{ route('decks.store') }}" method="POST" class="form-container">
        @csrf
        <label for="name">デッキ名:</label>
        <input type="text" id="name" name="name" required class="input-custom">
        <button type="submit" class="submit-button">作成</button>
    </form>
@endsection
