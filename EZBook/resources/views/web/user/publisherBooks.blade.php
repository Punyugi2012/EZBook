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
		<p>ที่อยู่: {{$publisher->address}}</p>
		<p>อีเมลล์: {{$publisher->user->email}}</p>
		<p>เบอร์โทรศัพท์: {{$publisher->phone}}</p>
		<div class="row">
			@for ($i = count($books) - 1; $i >= 0; $i--)
				<div class="col-md-3 text-center">
					<a href="/book/{{$books[$i]->id}}">
						<img class="border border-secondary rounded" src="{{$books[$i]->url_cover_image}}" alt="cover image" style="width:150px;height:200px"
						/>
					</a>
					<p style="margin-top:10px">ชื่อหนังสือ: {{$books[$i]->name}}</p>
					<p>ราคา: {{$books[$i]->price == 0 ? 'ฟรี' : $books[$i]->price.' บาท'}}</p>
					<p>%ส่วนลด: {{$books[$i]->discount_percent}} %</p>
					<p>ราคาสุทธิ: {{$books[$i]->price - ($books[$i]->price * ($books[$i]->discount_percent / 100))}} บาท</p>
					<p>สถานะ:
						<span class="{{$books[$i]->status == 'able' ? 'text-success' : 'text-danger'}}">{{$books[$i]->status == 'able' ? 'วางขายอยู่' : 'ยังไม่วางขาย'}}</span>
					</p>
				</div>
			@endfor
		</div>
	</div>
</div>
@endsection