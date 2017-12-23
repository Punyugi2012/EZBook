@extends('web.templates.app')
@section('title', 'หน้าหลัก')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <style>
        .carousel img {
            height:350px;
            object-fit:fill;
        }
    </style>
    <div style="margin-top:100px">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" style="height:350px">
                <div class="carousel-item">
                    <img class="d-block w-100 rounded img-thumbnail" src="https://hilight.kapook.com/img_cms2/other1/bookexpo2011.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 rounded  img-thumbnail" src="http://www.libraryhub.in.th/wp-content/uploads/2009/10/bookexpo.jpg" alt="Third slide">
                </div>
                <div class="carousel-item active">
                    <img class="d-block w-100 rounded img-thumbnail" src="http://www.baanlaesuan.com/wp-content/uploads/2016/10/14666086_1315246585176089_4983327205539273554_n.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div style="margin-top:10px">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{$isNewBook ? 'active' : ''}}" href="/">หนังสือมาใหม่</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$isRecommend ? 'active' : ''}}" href="/recommend">หนังสือแนะนำ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$isFree ? 'active' : ''}}" href="/free">หนังสือฟรี</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$isDiscount ? 'active' : ''}}" href="/discount">หนังสือลดราคา</a>
                </li>
            </ul>
        </div>
        <div>
            @if($isNewBook)
                <div class="card" style="border-top:0px;border-radius:0px">
                    <div class="card-body">
                        @if (count($books) == 0)
                            <div class="alert alert-warning text-center">
                                ไม่พบหนังสือมาใหม่
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
                                    <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                     <div>
                        <a class="float-right" href="/newbooks"><span class="badge badge-light">ดูหนังสือใหม่เพิ่มเติม</span></a>
                    </div>
                </div>
            @elseif($isRecommend)
                <div class="card" style="border-top:0px;border-radius:0px">
                    <div class="card-body">
                        @if (count($books) == 0)
                            <div class="alert alert-warning text-center">
                                ไม่พบหนังสือแนะนำ
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
                                        <p>ราคา: <span class="badge badge-primary">{{$book->price}}</span> บาท
                                    @else
                                        <p>ราคา
                                            <span style="text-decoration: line-through;">{{$book->price}}</span> 
                                            <sub>ลด {{$book->discount_percent}}%</sub> <span class="badge badge-primary">{{$book->price - ($book->price * $book->discount_percent / 100)}}</span> บาท
                                        </p>
                                    @endif
                                    <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                     <div>
                        <a class="float-right" href="/recommendBooks"><span class="badge badge-light">ดูหนังสือแนะนำเพิ่มเติม</span></a>
                    </div>
                </div>
            @elseif($isFree)
                <div class="card" style="border-top:0px;border-radius:0px">
                    <div class="card-body">
                        @if (count($books) == 0)
                        <div class="alert alert-warning text-center">
                            ไม่ไม่หนังสือฟรี
                        </div>
                        @endif
                        <div class="row">
                            @foreach($books as $book)
                                <div class="col-md-3 text-center">
                                    <a href="/book/{{$book->id}}">
                                        <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                                    </a>
                                    <p>{{$book->name}}</p>
                                    <p><span class="badge badge-success">ฟรี</span></p>
                                    <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                     <div>
                        <a class="float-right" href="/freebooks"><span class="badge badge-light">ดูหนังสือฟรีเพิ่มเติม</span></a>
                    </div>
                </div>
            @elseif($isDiscount)
                <div class="card" style="border-top:0px;border-radius:0px">
                    <div class="card-body">
                        @if (count($books) == 0)
                        <div class="alert alert-warning text-center">
                            ไม่พบหนังสือลดราคา
                        </div>
                        @endif
                        <div class="row">
                        @foreach($books as $book)
                            <div class="col-md-3 text-center">
                                <a href="/book/{{$book->id}}">
                                    <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                                </a>
                                <p>{{$book->name}}</p>
                                <p>ราคา <span style="text-decoration: line-through;">{{$book->price}}</span> <sub>ลด {{$book->discount_percent}}%</sub> <span class="badge badge-primary">{{$book->price - ($book->price * $book->discount_percent / 100)}}</span> บาท</p>
                                <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div>
                        <a class="float-right" href="/discountbooks"><span class="badge badge-light">ดูหนังสือลดราคาเพิ่มเติม</span></a>
                    </div>
                </div>
            @endif
        </div>
        <div class="card" style="margin-top:20px">
            <div class="card-header">
                อันดับหนังสือที่คนอ่านมากที่สุด
            </div>
            <div class="card-body">
                @if (count($topBooks) == 0)
                <div class="alert alert-warning text-center">
                    ไม่พบอันดับหนังสือ
                </div>
                @endif
                <div class="row">
                    @foreach($topBooks as $book)
                        <div class="col-md-3 text-center">
                            <a href="/book/{{$book->id}}">
                                <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                            </a>
                            <p>{{$book->name}}</p>
                            @if($book->price == 0)
                                <p>ราคา: <span class="badge badge-success">ฟรี</span></p>
                            @elseif($book->discount_percent == 0) 
                                <p>ราคา: <span class="badge badge-primary">{{$book->price}}</span> บาท
                            @else
                                <p>ราคา
                                    <span style="text-decoration: line-through;">{{$book->price}}</span> 
                                    <sub>ลด {{$book->discount_percent}}%</sub>  <span class="badge badge-primary">{{$book->price - ($book->price * $book->discount_percent / 100)}}</span> บาท
                                </p>
                            @endif
                            <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card" style="margin-top:20px">
            <div class="card-header">
                สำนักพิมพ์/นักเขียน อัปเดทล่าสุด
            </div>
            <div class="card-body">
                @if (count($publishers) == 0)
                <div class="alert alert-warning text-center">
                    ไม่พบสำนักพิมพ์/นักเขียน
                </div>
                @endif
                <div class="row">
                    @foreach($publishers as $publisher)
                        <div class="col-md-3">
                            <a href="/user-books/publisher/{{$publisher->id}}">{{$publisher->name}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <a href="/publishers" class="float-right"><span class="badge badge-light">สำนักพิมพ์/นักเขียนเพิ่มเติม</span></a>
            </div>
        </div>
        <div class="card" style="margin-top:20px">
            <div class="card-header">
                ข่าวสาร
            </div>
            <div class="card-body">
                @if (count($infos) == 0)
                <div class="alert alert-warning text-center">
                    ไม่พบข่าวสาร
                </div>
                @endif
                <div class="row">
                    @foreach($infos as $info)
                        <div class="col-md-12">
                            <a href="/info/{{$info->id}}">{{$info->created_at}} <span style="margin-left:50px">{{$info->title}}</span></a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <a href="/infos" class="float-right"><span class="badge badge-light">ข่าวสารเพิ่มเติม</span></a>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
            $('.carousel').carousel({})
    </script>
@endsection
