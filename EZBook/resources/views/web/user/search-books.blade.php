@extends('web.templates.app')
@section('title', 'SearchBooks')
@section('header')
    @include('web.components.header')
@endseciton
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card" style="margin-top:100px">
                <div class="card-body">
                    <form>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="search">ค้นหา:</label>
                            <input type="text" name="search" id="search" value="{{$search}}" class="form-control">
                        </div>
                         <div class="form-group">
                            <label for="search-type">เลือกประเภท:</label>
                            <select class="form-control" id="search-type" name="search-type">
                                <option value="">หนังสือทั้งหมด</option>
                                @foreach($bookTypes as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card" style="margin-top:20px">
        <div class="card-header">
            ได้ค้นหา {{$search}}, พบ {{$found}} เล่ม
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

@endsection