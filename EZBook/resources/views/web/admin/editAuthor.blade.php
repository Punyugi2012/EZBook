@extends('web.templates.app') @section('title', 'EditAuthor') @section('header')
<nav class="navbar navbar-light bg-light justify-content-between">
	<span>
		<a href="/admin-dashboard" class="navbar-brand">EZBooks</a>
	</span>
	<span>
		<a href="/admin-logout" class="btn btn-primary">Logout</a>
	</span>
</nav>
@endsection @section('content')
<div class="border border-secondary rounded" style="padding: 50px; margin-top: 30px">
	<h1>แก้ไข ผู้แต่ง</h1>
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
@endsection