@extends('web.templates.app') 
@section('title', 'BookProfile') 
@section('header')
@include('web.components.headerThird')
@endsection @section('content')
<div class="card" style="margin-top:20px;margin-bottom:60px;">
	<div class="card-header">
		<span style="font-size:20px">
		หนังสือ: <a href="javascript:void(0)">{{$book->name}}</a>
		</span>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-9 text-center">
				<div class="row">
					<div class="col-md-5">
						รูปภาพ: 
						@foreach($book->bookImages as $image)
						<div>
							<a href="{{$image->url_image}}" target="_blank">
								<img src="{{$image->url_image}}" alt="image" style="width:100px;height:100px" />
							<a>
						</div>
						<br> 
						@endforeach
						@if(count($book->bookImages) == 0)
							<p>ไม่มีรูปภาพประกอบ</p>
						@endif
					</div>
					<div class="col-md-7 text-center">
						<p>คะแนน: {{$book->score}}</p>
						<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:250px;height:300px"
						/>
                        <p>
                            <a href="{{$book->url_file}}" target="_blank">อ่าน</a>
                        </p>
                        <p>
                            <a href="{{$book->url_file}}" download>ดาวน์โหลด</a>
                        </p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<p>ชื่อหนังสือ: {{$book->name}}</p>
				<p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.' บาท'}}</p>
				<p>ส่วนลด: {{$book->discount_percent}} %</p>
				<p>ราคาสุทธิ: {{$book->price - ($book->price * ($book->discount_percent / 100))}} บาท</p>
				<p>ประเภท: {{$book->bookType->name}}</p>
				<p>ขนาดไฟล์: {{$book->file_size}}</p>
				<p>จำนวนหน้า: {{$book->num_page}} หน้า</p>
				<p>จำนวนผู้อ่าน: {{$book->num_read}}</p>
				ผู้แต่ง:
				<div style="padding-left:20px">
					@foreach($book->authors as $author)
					<a href="javascript:void(0)" class="d-block">{{$author->name}}</a>
					@endforeach
				</div>
				<br>
				<p>
					สำนักพิมพ์:
					<a href="javascript:void(0)">{{$book->publisher->name}}</a>
				</p>
				<p>วันที่ตีพิมพ์: {{$book->date_publish}}</p>
				<p>สถานะ:
					<span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขาย' : 'ยังไม่วางขาย'}}</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				รายละเอียด: 
				<p>{{$book->detail}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				ความคิดเห็น:
				@if(count($book->comments) == 0)
					<div class="alert alert-warning text-center">
						ไม่มีความคิดเห็นสำหรับหนังสือเล่มนี้
					</div>
                @else
                    <div style="border:1px solid #ced4da" class="rounded">
                        <ul class="list-group" style="overflow:auto">
                            @foreach($book->comments as $comment)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        @if($comment->member->url_image != "/storage/")
                                            <img src="{{$comment->member->url_image}}" class="rounded-circle" style="width:50px;height:50px" title="{{$comment->member->name}}">
                                        @else 
                                            <img src="https://cdn0.iconfinder.com/data/icons/users-android-l-lollipop-icon-pack/24/user-512.png" class="rounded-circle" style="width:50px;height:50px" title="{{$comment->member->name}}">
                                        @endif
                                        {{$comment->message}}
                                    </span>
                                    <span class="badge badge-primary badge-pill">{{$comment->created_at}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection