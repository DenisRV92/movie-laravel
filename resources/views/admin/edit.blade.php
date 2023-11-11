@extends('admin.index')

@section('main-content')
    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH') {{-- Это spoofing метода, чтобы использовать PATCH, а не POST --}}

        <div>
            <label for="preview">Превью</label>
            <input type="file" name="preview" id="preview">
            {{-- Показать текущее изображение превью, если оно существует --}}
            @if($movie->preview)
                <img src="{{ Storage::url($movie->preview) }}" width="100px;">
            @endif
        </div>
        <div>
            <label for="gallery">Галерея</label>
            <input type="file" name="gallery[]" id="gallery" multiple>
            {{-- Показать текущие изображения из галереи, если они существуют --}}
            @if($movie->gallery)
                @foreach($movie->gallery as $image)
                    <img src="{{ Storage::url($image) }}" width="100px;">
                @endforeach
            @endif
        </div>

        <input type="submit" value="Обновить изображения">
    </form>
@endsection
