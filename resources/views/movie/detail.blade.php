<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,
        body {
            position: relative;
            height: 100%;
            padding: 20px;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .preview{
            height: 300px !important;
            width: 480px !important;
            object-fit: cover;
        }

    </style>
</head>
<body>
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
<div style="display: flex">
    <div style="width: 40%" class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php foreach($movie->gallery as $image): ?>
            <div class="swiper-slide">
                @if(Str::startsWith($image, 'public/'))
                    <img class="preview" src="{{ asset(Storage::url(Str::replaceFirst('public/', '', $image))) }}" alt="">
                @else
                    <img class="preview" src="{{$image}}" alt="">
                @endif
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div style="width: 60%">
        <div><b>Название:</b>{{$movie->title}}</div>
        <div><b>Актеры:</b> {{$movie->actors->pluck('name')->implode(', ')}}</div>
        <div><b>Режиссер:</b>{{$movie->directors->pluck('name')->implode(', ')}}</div>
    </div>
</div>
<div>
    <form style="margin: 30px" action="#" method="POST">
        @csrf
        <div>
            <label for="message">Написать отзыв:</label>
            <textarea id="message" name="message" rows="5" cols="33">
        </textarea>
            <input class="message-review" type="submit" value="Отправить">
        </div>
    </form>
    <div class="reviews">
        @foreach($movie->reviews as $review)
            <div>
                <p>Автор: {{ $review->user->name }}</p>
                <div
                    style="width: 40%; background: white;height: 60px;border: solid 1px black;margin-bottom: 10px">{{ $review->message }}</div>
            </div>
        @endforeach
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
        },
    });

    $('form').on('click', '.message-review', function (event) {
        event.preventDefault();
        let form = $(this).closest('form');
        let formData = form.serialize();
        $.ajax({
            url: '/review/<?php echo $movie->id ?>',
            type: 'POST',
            data: formData,
            success: function (response) {
                form[0].reset();
                $('.reviews').html(response)
            },
            error: function (response) {
                console.log(response)
            }
        });
    });
</script>
</body>
</html>

