@extends('web.templates.app')
@section('title', 'FreeBooks')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            หนังสือฟรีทั้งหมด
        </div>
        <div class="card-body">
            <div class="row">
             @foreach($books as $book)
                <div class="col-md-3 text-center">
                    <a href="/book/{{$book->id}}">
                        <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                    </a>
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
        <div>
            {{$books->links()}}
        </div>
    </div>
@endsection