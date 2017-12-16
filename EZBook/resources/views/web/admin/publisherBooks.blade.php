@extends('web.templates.app') @section('title', 'BookProfile') @section('header')
<nav class="navbar navbar-light bg-light justify-content-between">
	<span>
		<a href="/admin-dashboard" class="navbar-brand">EZBooks Admin</a>
	</span>
	<span>
		<a href="/admin-logout" class="btn btn-primary">Logout</a>
	</span>
</nav>
@endsection @section('content')
<a href='/admin-publishers' class="btn btn-primary" style="margin-top: 10px">ย้อนกลับ</a>
<div class="card" style="margin-top:20px;margin-bottom:60px;">
	<div class="card-header">
		สำนักพิมพ์: {{$publisher->name}}, มีหนังสือทั้งหมด: {{count($books)}} เล่ม
	</div>
	<div class="card-body">
		<div class="row">
			@foreach($books as $book)
				<div class="col-md-3">
					<a href="/admin-book/{{$book->id}}">
						<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:150px;height:200px"/>
					</a>
					<p style="margin-top:10px">ชื่อหนังสือ: {{$book->name}}</p>
					<p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.' บาท'}}</p>
					<p>%ส่วนลด: {{$book->discount_percent}} %</p>
					<p>ราคาสุทธิ: {{$book->price - ($book->price * ($book->discount_percent / 100))}} บาท</p>
					<p>สถานะ: <span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขายอยู่' : 'ยังไม่วางขาย'}}</span></p>
				</div>
			@endforeach
		</div>
	</div>
</div>
@endsection