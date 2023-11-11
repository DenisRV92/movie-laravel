<div style="display: flex;flex-wrap: wrap; justify-content: space-around" class="row">
    @foreach ($movies as $movie)
        <div style="flex: 0 0 30%; padding: 30px;text-decoration:none; color: inherit;">
            <p>{{$movie->title}}</p>
            @if ($user?->movies->contains($movie->id))
                <p class="my-favorite" data-id="{{$movie->id}}" style="cursor: pointer;font-size: 40px">
                    &#10027;</p>
            @else
                <p class="favorite" data-id="{{$movie->id}}" style="cursor: pointer;font-size: 40px">
                    &#10027;</p>
            @endif
            <a href="{{ route('show', ['genre' => Str::lower($movie->genres->first()->name), 'movie' => $movie->slug ]) }}">
                @if(Str::startsWith($movie->preview, 'public/'))
                    <img class="preview"
                         src="{{ asset(Storage::url(Str::replaceFirst('public/', '', $movie->preview))) }}" alt="">
                @else
                    <img class="preview" src="{{$movie->preview}}" alt="">
                @endif
            </a>
        </div>
    @endforeach
</div>
<div>{{ $movies->links() }}</div>
