@extends('web.templates.app') @section('title', 'PublisherBooks') @section('header') @include('web.components.header') @endsection
@section('content')
<div class="card" style="margin-top:100px;margin-bottom:60px;">
	<div class="card-header">
		สำนักพิมพ์:
		<a href="javascript:void(0)">{{$publisher->name}}</a>, ประเภท
		<a href="javascript:void(0)">{{$type}}</a>, ทั้งหมด:
		<a href="javascript:void(0)">{{count($books)}}</a> เล่ม
		<div class="dropdown float-right">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
			 aria-expanded="false">
				จัดเรียงตามประเภท
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="/user-books/publisher/{{$publisher->id}}">ทั้งหมด</a>
				@foreach($bookTypes as $type)
				<a class="dropdown-item" href="/user-books/publisher/{{$publisher->id}}/{{$type->id}}">{{$type->name}}</a>
				@endforeach
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			@foreach($books as $book)
			<div class="col-md-3 text-center">
				<a href="/book/{{$book->id}}">
					<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:150px;height:200px"
					/>
				</a>
				<p style="margin-top:10px">ชื่อหนังสือ: {{$book->name}}</p>
				<p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.' บาท'}}</p>
				<p>%ส่วนลด: {{$book->discount_percent}} %</p>
				<p>ราคาสุทธิ: {{$book->price - ($book->price * ($book->discount_percent / 100))}} บาท</p>
				<p>สถานะ:
					<span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขายอยู่' : 'ยังไม่วางขาย'}}</span>
				</p>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection