@extends('web.templates.app') @section('title', 'Book') @section('header') @include('web.components.header') @endseciton
@section('content')
<div class="card" style="margin-top:100px">
	<div class="card-header">
		หนังสือ {{$book->name}}
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-9 text-center">
				<div class="row">
					<div class="col-md-5">
						รูปภาพ: 
                        @if(count($book->bookImages) == 0)
                            <p>ไม่มีรูปภาพประกอบ</p>
                        @endif
                        @foreach($book->bookImages as $image)
						<div>
							<a href="{{$image->url_image}}" target="_blank">
								<img src="{{$image->url_image}}" alt="image" style="width:100px;height:100px" />
							</a>
						</div>
						<br> 
                        @endforeach
					</div>
					<div class="col-md-7">
                        @if(session()->has('user'))
                            @if(!$isVoted)
                                <p>โหวต:</p>
                                <form>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="1"> 1
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote"  value="1.5"> 1.5
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote"  value="2"> 2
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="2.5"> 2.5
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="3"> 3
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="3.5"> 3.5
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="4"> 4
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="4.5"> 4.5
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="vote" value="5"> 5
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success">ยืนยันการโหวต</button>
                                    </div>
                                </form>
                            @else
                                โหวตแล้ว
                            @endif
                        @endif
                    	<p>คะแนน: {{$book->score}}</p>
						<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:250px;height:300px"
						/>
                        <div style="margin-top:20px">
                            
                                @if(!session()->has('user'))
                                    <a href="/user-login">กรุณา เข้าสู่ระบบ เพื่ออ่านหนังสือหรือซื้อหนังสือ</a>
                                @elseif($isBought)
                                    <a href="{{$book->url_file}}" target="_blank">อ่าน</a>
                                    <br>
                                    <a href="{{$book->url_file}}" target="_blank" download>ดาวน์โหลด</a>
                                @elseif(!$isBought)
                                    @if($book->status == 'able')
                                        @if($book->price == 0)
                                            <a href="#">อ่านฟรี</a>
                                        @else
                                            <a href="#">ซื้อหนังสือ</a>
                                        @endif
                                    @else
                                        ไม่วางขายแล้ว
                                    @endif
                                @endif
    
                        </div>
					</div>
				</div>
			</div>
			<div class="cold-md-6" style="padding:20px">
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
				<p>สำนักพิมพ์:
					<a href="javascript:void(0)">{{$book->publisher->name}}</a>
				</p>
				<p>วันที่ตีพิมพ์: {{$book->date_publish}}</p>
                <p>สถานะ:
					<span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขาย' : 'ไม่วางขายแล้ว'}}</span>
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
                @endif
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
                <form action="/user-comment/book/{{$book->id}}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="comment" style="width:100%" placeholder="แสดงความคิดเห็น">
                        <span class="input-group-btn">
                            @if(session()->has('user'))
                                @if($isBought)
                                    <button class="btn btn-secondary" type="submit">ส่ง</button>
                                @else
                                    <button class="btn btn-secondary" type="button" disabled>กรุณาซื้อหนังสือก่อน</button>
                                @endif
                            @else
                                <button class="btn btn-secondary" type="button" disabled>กรุณาเข้าสู่ระบบก่อน</button>
                            @endif
                        </span>
                    </div>
                </form>
            </div>
        </div>
	</div>

</div>

@endsection