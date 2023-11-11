@extends('admin.index')

@section('main-content')
    @foreach($reviews as $review)
   <div style="padding-bottom: 15px">{{$review->message}}</div>
    @endforeach
@endsection
