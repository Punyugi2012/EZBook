@extends('web.templates.app')
@section('title', 'ค้นหาหนังสือ')
@section('header')
    @include('web.components.header')
@endseciton
@section('content')
    <div class="row" style="margin-top:100px">
        <div class="col-md-6">
            <div class="card">
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
            <span style="font-size:20px">
                คุณได้ค้นหา <a href="javascript:void(0)">{{$search}}</a>, พบ <a href="javascript:void(0)">{{$books->total()}}</a> เล่ม
            </span>
        </div>
        <div class="card-body">
            @if (count($books) == 0)
            <div class="alert alert-warning text-center">
                ไม่พบหนังสือ
            </div>
            @endif
            <div class="row">
                @foreach($books as $book)
                    <div class="col-md-3 text-center">
                        <a href="/book/{{$book->id}}">
                            <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                        </a>
                        <p>{{$book->name}}</p>
                        @if($book->price == 0)
                            <p>ราคา: <span class="badge badge-success">ฟรี</span></p>
                        @elseif($book->discount_percent == 0) 
                            <p>ราคา: {{$book->price}}
                        @else
                            <p>ราคา:
                                <span style="text-decoration: line-through;">{{$book->price}}</span> 
                                <sub>ลด {{$book->discount_percent}}%</sub> <span class="badge badge-primary">{{$book->price - ($book->price * $book->discount_percent / 100)}}</span> บาท
                            </p>
                        @endif
                        <p>คะแนน: {{$book->score}}</p>
                        <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            {{$books->links()}}
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection