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
<div class="card" style="margin-top:20px;margin-bottom:60px;">
	<div class="card-header">
		หนังสือ: {{$book->name}}
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-9 text-center">
				<div class="row">
					<div class="col-md-5">
						รูปภาพ: @foreach($book->bookImages as $image)
						<div>
							<a href="{{$image->url_image}}" target="_blank">
								<img src="{{$image->url_image}}" alt="image" style="width:100px;height:100px" />
								<a>
						</div>
						<br> @endforeach
					</div>
					<div class="col-md-7">
						<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:250px;height:300px"
						/>
					</div>
				</div>
			</div>
			<div class="cold-md-6">
				<p>ชื่อหนังสือ: {{$book->name}}</p>
				<p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.' บาท'}}</p>
				<p>ส่วนลด: {{$book->discount_percent}} %</p>
				<p>ราคาสุทธิ: {{$book->price - ($book->price * ($book->discount_percent / 100))}} บาท</p>
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
				<p>สำนักพิมพ์:
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
				comments:
				<div style="overflow:auto;height:150px;padding:10px;border:1px solid #ced4da" class="rounded">
					
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:30px">
			<div class="col-md-12">
				แก้ไขสถานะ:
				<form action="/admin-update-book/{{$book->id}}" method="POST">
					<div class="form-check form-check-inline">
						<label class="form-check-label text-success">
							{{ csrf_field() }}
            				{{ method_field('PUT') }}
							<input class="form-check-input" type="radio" name="status" value="able" {{$book->status == 'able' ? 'checked' : ''}}> วางขาย
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label text-danger">
							<input class="form-check-input" type="radio" name="status" value="unable" {{$book->status == 'unable' ? 'checked' : ''}}> ไม่วางขาย
						</label>
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
					<button type="submit" class="btn btn-primary">บันทึก</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection