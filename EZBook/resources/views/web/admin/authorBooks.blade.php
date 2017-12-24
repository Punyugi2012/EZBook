@extends('web.templates.app') @section('title', 'หนังสือผู้แต่ง') @section('header')
@include('web.components.headerSecond')
@endsection @section('content')
<div class="card" style="margin-top:20px;margin-bottom:60px;">
	<div class="card-header">
		<span style="font-size:20px">
			ผู้แต่ง: <a href="javascript:void(0)">{{$author->name}}</a>, ประเภท <a href="javascript:void(0)">{{$type}}</a>, ทั้งหมด: <a href="javascript:void(0)">{{count($books)}}</a> เล่ม
		</span>
		<div class="dropdown float-right">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
			 aria-expanded="false">
				จัดเรียงตามประเภท
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="/admin-books/author/{{$author->id}}">ทั้งหมด</a>
				@foreach($bookTypes as $type)
					<a class="dropdown-item" href="/admin-books/author/{{$author->id}}/{{$type->id}}">{{$type->name}}</a>
				@endforeach
			</div>
		</div>
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
					<a href="/admin-book/{{$book->id}}">
						<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:150px;height:200px"/>
					</a>
					<p style="margin-top:10px">ชื่อหนังสือ: {{$book->name}}</p>
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
					<p>สถานะ: <span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขาย' : 'ไม่วางขาย'}}</span></p>
				</div>
			@endforeach
		</div>
	</div>
</div>
<div style="margin-bottom:300px">
</div>
@endsection