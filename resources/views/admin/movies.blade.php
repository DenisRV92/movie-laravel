@extends('admin.index')

@section('main-content')
    <style>
        th{
            text-align: left;
        }
    </style>
    <table width="50%">
        <thead>
        <tr>
            <th>Название</th>
            <th>Год</th>
            <th>Рейтинг</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($movies as $movie)
            <tr>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->year }}</td>
                <td>{{ $movie->rating }}</td>
                <td>
                    <a href="{{ route('admin.movies.edit', $movie->id) }}">Редактировать</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
