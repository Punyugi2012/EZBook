@extends('web.templates.app') @section('title', 'publisher register') @section('header')
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
	<h1>แก้ไข สำนักพิมพ์</h1>
	<form action="/admin-update-publisher/{{$publisher->id}}" method="POST">
		{{ csrf_field() }}
        {{ method_field('PUT') }}
		<div class="form-group">
			<label for="name">ชื่อ:</label>
			<input type="text" class="form-control" name="name" id="name" value="{{$publisher->name}}" placeholder="name" required>
		</div>
		<div class="form-group">
			<label for="address">ที่อยู่:</label>
			<input type="text" class="form-control" name="address" id="address" value="{{$publisher->address}}" placeholder="จังหวัด/อำเภอ/ตำบล" required>
		</div>
		<div class="form-group">
			<label for="phone">เบอร์โทรศัพท์:</label>
			<input type="number" class="form-control" name="phone" id="phone" value="{{$publisher->phone}}" placeholder="phone" required>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input class="form-check-input" type="radio" name="status" value="able" {{$publisher->status == 'able' ? 'checked' : ''}}> สัญญายังไม่หมด
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input class="form-check-input" type="radio" name="status" value="unable"  {{$publisher->status == 'unable' ? 'checked' : ''}}> หมดสัญญา
			</label>
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-primary">บันทึก</button>
			<button type="reset" class="btn btn-warning">ล้าง</button>
		</div>
	</form>
</div>
@endsection