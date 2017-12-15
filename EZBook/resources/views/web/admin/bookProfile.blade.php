@extends('web.templates.app') @section('title', 'BookProfile') @section('header')
<nav class="navbar navbar-light bg-light justify-content-between">
	<span>
		<a class="navbar-brand">EZBooks Admin</a>
	</span>
	<span>
		<a href="/admin-logout" class="btn btn-primary">Logout</a>
	</span>
</nav>
@endsection @section('content')
<a href='/admin-books' class="btn btn-primary" style="margin-top: 10px">ย้อนกลับ</a>
<div class="card" style="margin-top:20px;margin-bottom:60px;">
	<div class="card-header">
		หนังสือ: {{$book->name}}
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-9 text-center">
				<div class="row">
					<div class="col-md-5">
						รูปภาพ: @foreach($book->images as $image)
						<div>
							<a href="{{$image->url_image}}" target="_blank">
								<img src="{{$image->url_image}}" alt="image" style="width:100px;height:100px" />
								<a>
						</div>
						<br>
						@endforeach
					</div>
					<div class="col-md-4">
						<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:250px;height:300px"
						/>
						<div style="margin-top:20px">
							<a href="#editBook" class="btn btn-warning">แก้ไขหนังสือ</a>
						</div>
					</div>
				</div>
			</div>
			<div class="cold-md-6">
				<p>ชื่อหนังสือ: {{$book->name}}</p>
				<p>ราคา: {{$book->price}}</p>
				<p>ประเภท: {{$book->type}}</p>
				<p>ขนาดไฟล์: {{$book->file_size}}</p>
				<p>จำนวนหน้า: {{$book->num_page}} หน้า</p>
				<p>คะแนน: {{$book->score}}</p>
				<p>จำนวนผู้อ่าน:</p>
				ผู้แต่ง:
				<div style="padding-left:20px">
					@foreach($book->authors as $author)
					<a href="javascript:void(0)" class="d-block">{{$author->name}}</a>
					@endforeach
				</div>
				<br>
				<p>สำนักพิมพ์: {{$book->publisher->name}}</p>
				<p>วันที่ตีพิมพ์: {{$book->date_publish}}</p>
				<p>สถานะ:
					<span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขาย' : 'ยังไม่วางขาย'}}</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<p>รายละเอียด: {{$book->detail}}</p>
			</div>
		</div>
	</div>
</div>
<div class="card" style="margin-top:10px;margin-bottom:20px" id="editBook">
	<div class="card-header">
		แก้ไขหนังสือ
	</div>
	<div class="card-body">
		<form action="/admin-update-book/{{$book->id}}/publisher/{{$book->publisher->id}}" enctype="multipart/form-data" method="POST">
			{{ csrf_field() }}
            {{ method_field('PUT') }}
			<div class="form-group">
				<label for="publisher">สำนักพิมพ์:</label>
				<select class="form-control" id="publisher" name="publisher" required>
					<option value="">เลือกสำนักพิมพ์</option>
					@foreach($publishers as $publisher)
					<option value="{{$publisher->id}}">{{$publisher->name}}</option>
					@endforeach
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
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="status" value="able" checked> วางขาย
				</label>
			</div>
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="status" value="unable"> ยังไม่วางขาย
				</label>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-success">แก้ไข</button>
				<button type="reset" class="btn btn-warning">ล้าง</button>
			</div>
		</form>
	</div>
</div>
@endsection