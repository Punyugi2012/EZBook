@extends('web.templates.app') @section('title', 'BookProfile') @section('header')
@include('web.components.headerSecond')
@endsection @section('content')
<div class="card" style="margin-top:20px;margin-bottom:60px;">
	<div class="card-header">
		<span style="font-size:20px">
			หนังสือ: <a href="javascript:void(0)">{{$book->name}}</a>
		</span>
	</div>
	<div class="card-body">
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@elseif(session()->has('updatedBook'))
			<div class="alert alert-success text-center">
				{{session()->get('updatedBook')}}
			</div>
		@elseif(session()->has('deletedComment'))
			<div class="alert alert-success text-center">
				{{session()->get('deletedComment')}}
			</div>
		@endif
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
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<p>ชื่อหนังสือ: {{$book->name}}</p>
				<p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.' บาท'}}</p>
				<p>ส่วนลด: {{$book->discount_percent}} %</p>
				<p>ราคาสุทธิ: {{$book->price - ($book->price * ($book->discount_percent / 100))}} บาท</p>
				<p>ประเภท: {{$book->type}}</p>
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
					<span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขาย' : 'ไม่วางขาย'}}</span>
				</p>
				<p>created_at: {{formatDateThai($book->created_at)}}</p>
				<p>updated:  {{formatDateThai($book->updated_at)}}</p>
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
									<span>
                                    	<span class="badge badge-primary badge-pill">{{$comment->created_at}}</span>
										<button data-toggle="modal" data-target="#deleteComment" style="color:red"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
									</span>
                                </li>
								<div class="modal fade" id="deleteComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">คุณแน่ใจแล้วใช่ไหมที่จะลบ</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="/admin-delete-comment/book/{{$book->id}}" method="post">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
											<input type="hidden" name="commentId" value="{{$comment->id}}">
											<div class="modal-footer">
												<button type="submit" class="btn btn-primary">ลบ</button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
											</div>
										</form>
										</div>
									</div>
								</div>
                            @endforeach
                        </ul>
                    </div>
				@endif
			</div>
		</div>
		<div class="row" style="margin-top:30px">
			<div class="col-md-12">
				<form action="/admin-update-book/{{$book->id}}" method="POST">
					{{ csrf_field() }}
            		{{ method_field('PUT') }}
					แก้ไขการแนะนำ:
					<div class="form-group">
						<div class="form-check form-check-inline">
							<label class="form-check-label text-success">
								<input class="form-check-input" type="radio" name="recommend" value="yes" {{$book->recommend == 'yes' ? 'checked' : ''}}> แนะนำ
							</label>
						</div>
						<div class="form-check form-check-inline">
							<label class="form-check-label text-danger">
								<input class="form-check-input" type="radio" name="recommend" value="not" {{$book->recommend == 'not' ? 'checked' : ''}}> ไม่แนะนำ
							</label>
						</div>
					</div>
					แก้ไขสถานะ:
					<div class="form-group">
						<div class="form-check form-check-inline">
							<label class="form-check-label text-success">
								<input class="form-check-input" type="radio" name="status" value="able" {{$book->status == 'able' ? 'checked' : ''}}> วางขาย
							</label>
						</div>
						<div class="form-check form-check-inline">
							<label class="form-check-label text-danger">
								<input class="form-check-input" type="radio" name="status" value="unable" {{$book->status == 'unable' ? 'checked' : ''}}> ไม่วางขาย
							</label>
						</div>
					</div>
					<div class="form-group">
						<lable for="price">แก้ไขราคา:</label>
						<input type="number" class="form-control" name="price" value="{{$book->price}}" id="price">
					</div>
					<div class="form-group">
						<lable for="discount">แก้ไข % ส่วนลด:</label>
						<input type="number" class="form-control" name="discount" value="{{$book->discount_percent}}" id="discount">
					</div>
					<div class="form-group">
						  <label for="detail">แก้ไขรายละเอียด:</label>
						<textarea class="form-control" id="detail" name="detail" rows="3">{{$book->detail}}</textarea>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-primary">บันทึก</button>
						<button type="submit" class="btn btn-warning">ล้าง</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div style="margin-bottom:400px">
</div>
@endsection