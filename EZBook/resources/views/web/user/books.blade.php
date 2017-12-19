@extends('web.templates.app')
@section('titile', 'Home')
@section('header')
    @include('web.components.header')
@endseciton
@section('content')
<div style="margin-top:100px">
    <div class="card">
        <div class="card-header">
            หนังสือประเภท: {{$type->name}}
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($books as $book)
                    <div class="col-md-3 text-center">
                        <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                        <p>{{$book->name}}</p>
                        @if($book->price == 0)
                            <p>ราคา: ฟรี</p>
                        @else 
                            <p>ราคา <span style="text-decoration: line-through;">{{$book->price}}</span> <sub>ลด {{$book->discount_percent}}%</sub> {{$book->price - ($book->price * $book->discount_percent / 100)}} บาท</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            {{$books->links()}}
        </div>
    </div>
</div>
@endsection