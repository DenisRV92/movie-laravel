@foreach($movie->reviews as $review)
    <div>
        <p>Автор: {{ $review->user->name }}</p>
        <div
            style="width: 40%; background: white;height: 60px;border: solid 1px black;margin-bottom: 10px">{{ $review->message }}</div>
    </div>
@endforeach
