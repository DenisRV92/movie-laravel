<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<style>
    .preview {
        height: 300px;
        width: 480px;
        object-fit: cover;
    }

    .my-favorite {
        color: gold;
    }
</style>
<body class="font-sans antialiased">
<div style="height: 100px;">
    @auth
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
        </div>
    @else
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <a href="{{ route('login') }}"
               class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
        </div>
    @endauth
</div>
Жанры:
<select class="selectpicker selectpicker-genres" multiple data-selected-text-format="count > 1">
    @foreach($genres as $key => $genre)
        <option value="{{$key}}">{{$genre}}</option>
    @endforeach
</select>
<div class="filter">
    <form class="form-filter" action="#" method="post">
        @csrf
        <label for="release_date_before">До даты выпуска:</label>
        <input type="number" value="1990" min="1990" max="2023" name="release_date_before" id="release_date_before">

        <label for="release_date_after">После даты выпуска:</label>
        <input type="number" value="2023" min="1991" max="2023" name="release_date_after" id="release_date_after">

        <label for="rating_from">Рейтинг от:</label>
        <input type="number" value="5" name="rating_from" id="rating_from" min="5" max="10" step="1">

        <label for="rating_to">Рейтинг до:</label>
        <input type="number" value="10" name="rating_to" id="rating_to" min="6" max="10" step="1">

        <label for="actors">Актеры:</label>
        <select id="actors" class="selectpicker selectpicker-actors" multiple data-selected-text-format="count > 1">
            @foreach($actors as $key => $actor)
                <option value="{{$key}}">{{$actor}}</option>
            @endforeach
        </select>

        <label for="directors">Режиссеры:</label>
        <select id="directors" class="selectpicker selectpicker-directors">
            <option value="">Не выбрано</option>
            @foreach($directors as $key => $director)
                <option value="{{$key}}">{{$director}}</option>
            @endforeach
        </select>

        <button class="submit-filter" type="submit">Фильтровать</button>
    </form>
</div>
<div>
    <label for="sortDate">Сортировка по дате</label>
    <select id="sortDate" class="selectpicker selectpicker-sort-date">
        <option value="asc">По возрастанию</option>
        <option value="desc"> по убыванию</option>
    </select>
</div>
<div>
    <label for="sortRating">Сортировка по рейтингу</label>
    <select id="sortRating" class="selectpicker selectpicker-sort-rating">
        <option value="asc">По возрастанию</option>
        <option value="desc"> по убыванию</option>
    </select>
</div>
<div>
    <label for="search">Поиск</label>
    <input class="search" type="text" id="search" name="search">
</div>
<div class="movie">
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
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function () {
        $('.selectpicker').select2();

    });
    $('.search').on('input', function (e) {
        let searchTerm = $(this).val();
        $.ajax({
            url: '/movie/filter',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                search: searchTerm,
            },
            success: function (response) {
                $('.movie').html(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
    $('.selectpicker-sort-date').change(function (event) {
        let order = $(this).val();
        event.preventDefault();

        $.ajax({
            url: '/movie/filter',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                sort_by_date: order,
            },
            success: function (response) {
                $('.movie').html(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    $('.selectpicker-sort-rating').change(function (event) {
        let order = $(this).val();
        event.preventDefault();

        $.ajax({
            url: '/movie/filter',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                sort_by_rating: order,
            },
            success: function (response) {
                $('.movie').html(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    $('.selectpicker-genres').change(function (event) {
        let selectedItem = $(this).val();
        event.preventDefault();

        if (selectedItem.length > 0) {
            $.ajax({
                url: '/movie',
                type: 'POST',
                data: {genres: selectedItem},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('.movie').html(response)
                },
                error: function (response) {
                    console.log(response)
                }
            });
        }
    });

    $('.form-filter').on('click', '.submit-filter', function (event) {
        event.preventDefault();
        let form = $(this).closest('.form-filter');
        let actorsVal = $('.selectpicker-actors').select2('val');
        let directorsVal = $('.selectpicker-directors').select2('val');

        let extraData = {
            actors: actorsVal,
            directors: directorsVal
        };

        let formData = form.serialize() + '&' + $.param(extraData);

        $.ajax({
            url: '/movie/filter',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('.movie').html(response)
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
    $('body').on('click', '.favorite', function (event) {
        event.preventDefault();
        let movieId = $(this).data('id');
        let favorite = $(this)
        let user = <?php echo $user ? json_encode($user) : 'null'; ?>;

        console.log(user)
        if (user != null) {
            $.ajax({
                url: '/movie/add-favorite/' + movieId,
                type: 'GET',

                success: function (response) {
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });

</script>
</html>
