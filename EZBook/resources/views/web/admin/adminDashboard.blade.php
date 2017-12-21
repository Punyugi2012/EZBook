@extends('web.templates.app') @section('title', 'Dashboard') @section('header')
<nav class="navbar navbar-light bg-light justify-content-between">
	<span>
		<a href="/admin-dashboard" class="navbar-brand">EZBooks Admin</a>
	</span>
	<span>
		<a href="/admin-logout" class="btn btn-primary">Logout</a>
	</span>
</nav>
@endsection @section('content')
<style>
	.nav li {
		margin-left: 5px;
	}
</style>
<div style="margin-top:20px">
	<ul class="nav nav-pills flex-column flex-sm-row">
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isPublishers?'active':''}}" href="/admin-publishers">สำนักพิมพ์</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isMembers?'active':''}}" href="/admin-members">สมาชิก</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isAuthors?'active':''}}" href="/admin-authors">ผู้แต่ง</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isUploadBooks?'active':''}}" href="/admin-uploadbooks">เพิ่มหนังสือ</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isBooks?'active':''}}" href="/admin-books">หนังสือ</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isNews?'active':''}}" href="/admin-news">ข่าวสาร</a>
		</li>
	</ul>
</div>
<div style="margin-bottom:60px;margin-top:10px">
	@if($isPublishers)
	<div class="card">
		<div class="card-header">
			@if($isSearch)
			คุณได้ค้นหา {{$search}}, พบ {{$publishers->total()}}
			@else
			<span>สำนักพิมพ์</span>, ทั้งหมด <a href="javascript:void(0)">{{$publishers->total()}}</a>
			@endif
			<form action="/admin-search/publishers" method="GET" class="float-right" style="width: 50%" autocomplete="off">
				{{ csrf_field() }}
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="submit">ค้นหา</button>
					</span>
					<input type="text" name="search" class="form-control" placeholder="ค้นหาโดย ชื่อสำนักพิมพ์/เบอร์โทรศัพท์/อีเมลล์">
				</div>
			</form>
		</div>
		<div class="card-body">
			<a href="/admin-regis-publisher" class="btn btn-info">เพิ่มสำนักพิมพ์</a>
			<table class="table table-striped" style="margin-top:10px">
				<thead>
					<tr>
						<th>ชื่อ</th>
						<th>ที่อยู่</th>
						<th>เบอร์โทรศัพท์</th>
						<th>อีเมลล์</th>
						<th>สถานะ</th>
						<th>Username</th>
						<th>Password</th>
						<th>created_at</th>
						<th>updated_at</th>
						<th>เครื่องมือ</th>
					</tr>
				</thead>
				<tbody>
					@foreach($publishers as $publisher)
					<tr>
						<td>{{$publisher->name}}</td>
						<td>{{$publisher->address}}</td>
						<td>{{$publisher->phone}}</td>
						<td>{{$publisher->email}}</td>
						<td>
							@if($publisher->status == 'able')
							<span class="text-success">สัญญายังไม่หมด</span>
							@else
							<span class="text-danger">หมดสัญญา</span>
							@endif
						</td>
						<td>{{$publisher->username}}</td>
						<td>{{$publisher->password}}</td>
						<td>{{$publisher->created_at}}</td>
						<td>{{$publisher->updated_at}}</td>
						<td>
							<a href="/admin-edit-publisher/{{$publisher->id}}" class="btn btn-warning">แก้ไข</a>
							<a href="/admin-books/publisher/{{$publisher->id}}" class="btn btn-info">ดูหนังสือ</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{$publishers->links()}}
		</div>
	</div>
	@elseif($isUploadBooks)
	<div class="card">
		<div class="card-header">
			เพิ่มหนังสือ
		</div>
		<div class="card-body">
			<form action="/admin-create-book" enctype="multipart/form-data" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="publisher">สำนักพิมพ์:</label>
					<select class="form-control" id="publisher" name="publisher" required>
						<option value="">เลือกสำนักพิมพ์</option>
						@foreach($publishers as $publisher) @if($publisher->status == 'able')
						<option value="{{$publisher->id}}">{{$publisher->name}}</option>
						@endif @endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="type">ประเภทหนังสือ:</label>
					<select class="form-control" id="type" name="type" required>
						<option value="">เลือกประเภทหนังสือ</option>
						@foreach($bookTypes as $type)
						<option value="{{$type->id}}">{{$type->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="name">ชื่อหนังสือ:</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="ชื่อหนังสือ" required>
				</div>
				<div class="form-group">
					<label for="detail">รายละเอียด:</label>
					<textarea class="form-control" id="detail" name="detail" rows="3" placeholder="รายละเอียด"></textarea>
				</div>
				เลือกผู้แต่ง:
				<div style="overflow:auto;height:100px;padding:10px;border:1px solid #ced4da" class="rounded">
					@foreach($authors as $author)
					<div class="form-check">
						<label class="form-check-label">
							<input type="checkbox" name="authors[]" class="form-check-input" value="{{$author->id}}"> {{$author->name}}
						</label>
					</div>
					@endforeach
				</div>
				<br>
				<div class="form-group">
					<label for="detail">ราคา:</label>
					<input type="number" class="form-control" name="price" id="price" value="0" placeholder="ราคา" required>
				</div>
				<div class="form-group">
					<label for="discount">% ส่วนลด:</label>
					<input type="number" class="form-control" name="discount" id="discount" value="0" placeholder="%ส่วนลด" required>
				</div>
				<div class="form-group">
					<label for="file_size">ขนาดไฟล์:</label>
					<input type="text" class="form-control" name="file_size" id="file_size" placeholder="ขนาดไฟล์" required>
				</div>
				<div class="form-group">
					<label for="num_page">จำนวนหน้า:</label>
					<input type="number" class="form-control" name="num_page" id="num_page" placeholder="จำนวนหน้า" required>
				</div>
				<div class="form-group">
					<label for="publish">วันที่ตีพิมพ์:</label>
					<input type="date" class="form-control" name="publish" id="publish" required>
				</div>
				<div class="form-group">
					<img id="blah" src="#" alt="your cover image" style="max-width:200px;max-height:200px" />
					<br>
					<label for="cover_image">รูปปก:</label>
					<input type="file" class="form-control" name="cover_image" id="cover_image" required>
				</div>
				<div class="form-group">
					your images
					<div class="gallery"></div>
					<label for="images">รูป:</label>
					<input type="file" class="form-control" multiple name="images[]" id="images">
				</div>
				<div class="form-group">
					<label for="file">file:</label>
					<input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
				</div>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="status" value="able" checked> วางขาย
					</label>
				</div>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="status" value="unable"> ไม่วางขาย
					</label>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-success">เพิ่ม</button>
					<button type="reset" class="btn btn-warning">clear</button>
				</div>
			</form>
		</div>
	</div>
	@elseif($isMembers)
	<div class="card">
		<div class="card-header">
			@if($isSearch)
				คุณได้ค้นหา {{$search}}, พบ {{$members->total()}}
			@else
				<span>สมาชิก</span>, ทั้งหมด <a href="javascript:void(0)">{{$members->total()}}</a>
			@endif
			<form action="/admin-search/members" method="GET" class="float-right" style="width: 50%">
				{{ csrf_field() }}
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="submit">ค้นหา</button>
					</span>
					<input type="text" name="search" class="form-control" placeholder="ค้นหาโดย ชื่อ/นามสกุล/อีเมลล์/เบอร์โทรศัพท์">
				</div>
			</form>
		</div>
		<div class="card-body">
			<div class="card-body">
				<table class="table table-striped" style="margin-top:10px">
					<thead>
						<tr>
							<th>ชื่อ</th>
							<th>นามสกุล</th>
							<th>เบอร์โทรศัพท์</th>
							<th>อีเมลล์</th>
							<th>ที่อยู่</th>
							<th>อายุ</th>
							<th>วันเกิด</th>
							<th>สถานะ</th>
							<th>รูปประจำตัว</th>
							<th>created_at</th>
							<th>updated_at</th>
							<th>เครื่องมือ</th>
						</tr>
					</thead>
					<tbody>
						@foreach($members as $member)
							<tr>
								<td>{{$member->name}}</td>
								<td>{{$member->surname}}</td>
								<td>{{$member->phone}}</td>
								<td>{{$member->email}}</td>
								<td>{{$member->address}}</td>
								<td>{{$member->age}}</td>
								<td>{{$member->birthday}}</td>
								<td>{{$member->status == 'able' ? 'ใช้งาน' : 'ไม่ใช้งาน'}}</td>
								<td>
									@if($member->url_image != "/storage/")
                                        <img src="{{$member->url_image}}" class="rounded-circle" style="width:50px;height:50px">
                                    @else 
                                        <img src="https://cdn0.iconfinder.com/data/icons/users-android-l-lollipop-icon-pack/24/user-512.png" class="rounded-circle" style="width:50px;height:50px">
                                    @endif
								</td>
								<td>{{$member->created_at}}</td>
								<td>{{$member->updated_at}}</td>
								<td>
									<button class="btn btn-warning">แก้ไขสถานะ</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{$members->links()}}
			</div>
		</div>
	</div>
	@elseif($isBooks)
	<div class="card">
		<div class="card-header">
			@if($isSearch)
				คุณได้ค้นหา {{$search}}, พบ {{$numOfBook}}
			@else
				ทั้งหมด <a href="javascript:void(0)">{{$numOfBook}}</a> เล่ม
			@endif
			<form action="/admin-search/books" method="GET" class="float-right" style="width: 50%" autocomplete="off">
				{{ csrf_field() }}
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="submit">ค้นหา</button>
					</span>
					<input type="text" name="search" class="form-control" placeholder="ค้นหาโดย ชื่อหนังสือ">
				</div>
			</form>
		</div>
		<div class="card-body">
			<div id="accordion" role="tablist">
				@foreach($bookTypes as $type)
				<div class="card">
					<div class="card-header" role="tab" id="heading{{$loop->index}}">
						<a data-toggle="collapse" href="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
							ประเภท: {{$type->name}}, มีหนังสือจำนวน {{count($type->books)}} เล่ม
						</a>
					</div>
					<div id="collapse{{$loop->index}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$loop->index}}" data-parent="#accordion">
						<div class="card-body">
							<div class="card-body row">
								@foreach($type->books as $book)
								<div class="col-md-3 text-center">
									<a href="/admin-book/{{$book->id}}">
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
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@elseif($isAuthors)
	<div class="card">
		<div class="card-header">
			@if($isSearch)
			คุณได้ค้นหา {{$search}}, พบ {{$authors->total()}}
			@else
			<span>ผู้แต่ง</span>,
			ทั้งหมด <a href="javascript:void(0)">{{$authors->total()}}</a>
			@endif
			<form action="/admin-search/authors" method="GET" class="float-right" style="width: 50%" autocomplete="off">
				{{ csrf_field() }}
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="submit">ค้นหา</button>
					</span>
					<input type="text" name="search" class="form-control" placeholder="ค้นหาโดย ชื่อ/เบอร์โทรศัพท์/อีเมลล์">
				</div>
			</form>
		</div>
		<div class="card-body">
			<a href="/admin-regis-author" class="btn btn-info">เพิ่มผู้แต่ง</a>
			<table class="table table-striped" style="margin-top:10px">
				<thead>
					<tr>
						<th>ชื่อ</th>
						<th>อีเมลล์</th>
						<th>เบอร์โทรศัพท์</th>
						<th>created_at</th>
						<th>updated_at</th>
						<th>เครื่องมือ</th>
					</tr>
				</thead>
				<tbody>
					@foreach($authors as $author)
					<tr>
						<td>{{$author->name}}</td>
						<td>{{$author->email}}</td>
						<td>{{$author->phone}}</td>
						<td>{{$author->created_at}}</td>
						<td>{{$author->updated_at}}</td>
						<td>
							<a href="/admin-edit-author/{{$author->id}}" class="btn btn-warning">แก้ไข</a>
							<a href="/admin-books/author/{{$author->id}}" class="btn btn-info">ดูหนังสือ</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@elseif($isNews)
		<div class="card">
			<div class="card-header">
				ข่าวสาร, ทั้งหมด {{$infos->total()}}
			</div>
			<div class="card-body">
				<a href="/admin-create-news" class="btn btn-info">เพิ่มข่าวสาร</a>
				<table class="table table-striped" style="margin-top:10px">
					<thead>
						<tr>
							<th>หัวข้อ</th>
							<th>รายละเอียด</th>
							<th>created_at</th>
							<th>เครื่องมือ</th>
						</tr>
					</thead>
					<tbody>
						@foreach($infos as $info)
							<tr>
								<th>{{$info->title}}</th>
								<th>{{$info->description}}</th>
								<th>{{$info->created_at}}</th>
								<th>
									<a href="/admin-edit-news/{{$info->id}}" class="btn btn-warning">แก้ไข</a>
									<button class="btn btn-danger" data-toggle="modal" data-target="#deleteNews">ลบ</button>
								</th>
							</tr>
							<div class="modal fade" id="deleteNews" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">คุณแน่ใจแล้วใช่ไหมที่จะลบ</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="/admin-delete-news" method="post">
										{{ csrf_field() }}
            							{{ method_field('DELETE') }}
										<input type="hidden" name="newsId" value="{{$info->id}}">
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary">ลบ</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
										</div>
									</form>
									</div>
								</div>
							</div>
						@endforeach
					</tbody>
				</table>
				{{$infos->links()}}
			</div>
		</div>
	@endif
</div>
@endsection @section('javascript') @if($isUploadBooks)
<script type="text/javascript">
	$(document).ready(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#cover_image").on('change', function() {
                readURL(this);
            });   
            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img style="max-width:200px;max-height:200px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#images').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });

        });

</script>
@endif @endsection