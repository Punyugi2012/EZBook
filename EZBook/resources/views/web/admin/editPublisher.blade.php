@extends('web.templates.app') @section('title', 'EditPublisher') @section('header')
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
			<h1 class="text-center">แก้ไขสำนักพิมพ์/นักเขียน</h1>
			<form action="/admin-update-publisher/{{$publisher->id}}" method="POST" autocomplete="off">
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
						<input class="form-check-input" type="radio" name="status" value="able" {{$publisher->status == 'able' ? 'checked' : ''}}> <span class="text-success">สัญญายังไม่หมด</span>
					</label>
				</div>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="status" value="unable"  {{$publisher->status == 'unable' ? 'checked' : ''}}> <span class="text-danger">หมดสัญญา</span>
					</label>
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