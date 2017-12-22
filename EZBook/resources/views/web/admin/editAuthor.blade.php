@extends('web.templates.app') @section('title', 'EditAuthor') @section('header')
	@include('web.components.headerSecond')
@endsection @section('content')
<div class="border" style="padding: 50px; margin-top: 30px">
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="row">
		<div class="col-md-6" style="border-right:1px solid grey">
			<h1 class="text-center">แก้ไขผู้แต่ง</h1>
			<form action="/admin-update-author/{{$author->id}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<div class="form-group">
					<label for="name">ชื่อ:</label>
					<input type="text" class="form-control" name="name" id="name" value="{{$author->name}}" placeholder="ชื่อ" required>
				</div>
				<div class="form-group">
					<label for="email">อีเมลล์:</label>
					<input type="email" class="form-control" name="email" id="email" value="{{$author->email}}" placeholder="อีเมลล์" required>
				</div>
				<div class="form-group">
					<label for="phone">เบอร์โทรศัพท์:</label>
					<input type="number" class="form-control" name="phone" id="phone" value="{{$author->phone}}" placeholder="เบอร์โทรศัพท์" required>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-primary">บันทึก</button>
					<button type="reset" class="btn btn-warning">ล้าง</button>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดบันทึก</p>
		</div>
	</div>
</div>
@endsection