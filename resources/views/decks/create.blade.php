@extends('layouts.app')

@section('content')
    <h1>新規デッキ作成</h1>
    <form action="#" method="POST">
        @csrf
        <label for="name">デッキ名:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">作成</button>
    </form>
@endsection
