@extends('web.templates.app') @section('title', 'Dashboard') @section('header')
<nav class="navbar navbar-light bg-light justify-content-between">
	<span>
		<a href="/publisher-dashboard" class="navbar-brand">EZBooks Publisher</a>
	</span>
	<span>
		<a href="/publisher-logout" class="btn btn-primary">Logout</a>
	</span>
</nav>
@endsection @section('content')
<style>
	.nav li {
		margin-left: 5px;
	}
</style>
<div style="margin-top:20px">
	<ul class="nav nav-pills flex-column flex-sm-row" style="">
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isDashboard ? 'active' : ''}}" href="/publisher-dashboard">สรุป</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isBooks ? 'active' : ''}}" href="/publisher-books">หนังสือ</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isProfile ? 'active' : ''}}" href="/publisher-profile">ข้อมูลส่วนตัว</a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-light {{$isHistory ? 'active' : ''}}" href="/publisher-history">ประวัติการขาย</a>
		</li>
	</ul>
	<div style="margin-bottom:60px;margin-top:10px">
		@if($isDashboard)
		<div class="card" style="margin-top:20px">
			<div class="card-header">สรุป</div>
			<div class="card-body">
				<h4 class="card-title">ยอดการขาย</h4>
				<p class="card-text">{{$total}} บาท</p>
				<h4 class="card-title">หนังสือที่ขายดีที่สุด</h4>
				@if($topBook)
					<div>
						<a href="/publisher-book/{{$topBook->id}}">
							<img class="border border-secondary rounded" src="{{$topBook->url_cover_image}}" alt="cover image" style="width:150px;height:200px"
							/>
						</a>
						<p style="margin-top:10px">ชื่อหนังสือ: {{$topBook->name}}</p>
						<p>ราคา: {{$topBook->price == 0 ? 'ฟรี' : $topBook->price.' บาท'}}</p>
						<p>%ส่วนลด: {{$topBook->discount_percent}} %</p>
						<p>ราคาสุทธิ: {{$topBook->price - ($topBook->price * ($topBook->discount_percent / 100))}} บาท</p>
						<p>สถานะ:
							<span class="{{$topBook->status == 'able' ? 'text-success' : 'text-danger'}}">{{$topBook->status == 'able' ? 'วางขายอยู่' : 'ยังไม่วางขาย'}}</span>
						</p>
					</div>
				@endif
			</div>
		</div>
		@elseif($isBooks)
		<div class="card">
			<div class="card-header">
				@if($isSearch)
					คุณได้ค้นหา {{$search}}, พบ {{$numOfBook}} เล่ม
				@else
					ทั้งหมด
					<a href="javascript:void(0)">{{$numOfBook}}</a> เล่ม
				@endif
				<form action="/publisher-search/books" method="GET" class="float-right" style="width: 50%" autocomplete="off">
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
									<div class="col-md-3">
										<a href="/publisher-book/{{$book->id}}">
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
		@elseif($isProfile)
		<div class="card">
			<div class="card-header">
				ข้อมูลส่วนตัว
			</div>
			<div class="card-body">
				<h4 class="card-title">ชื่อสำนักพิมพ์/นักเขียน</h4>
				<p class="card-text">{{session()->get('publisher')->publisher->name}}</p>
				<h4 class="card-title">ที่อยู่</h4>
				<p class="card-text">{{session()->get('publisher')->publisher->address}}</p>
				<h4 class="card-title">เบอร์โทรศัพท์</h4>
				<p class="card-text">{{session()->get('publisher')->publisher->phone}}</p>
				<h4 class="card-title">สถานะ</h4>
				<p class="card-text">{{session()->get('publisher')->publisher->status == 'able' ? 'สัญญายังไม่หมด' : 'หมดสัญญาแล้ว'}}</p>
			</div>
		</div>
		@elseif($isHistory)
		<div class="card">
			<div class="card-header">
				ประวัติการขาย, จำนวน <a href="javascript:void(0)">{{count($purchases)}}</a> รายการ
			</div>
			<div class="card-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>วัน/เดือน/ปี/เวลา</th>
							<th>ชื่อหนังสือ</th>
							<th>ราคา</th>
                            <th>ชื่อลูกค้า</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($purchases as $purchase)
                            <tr>
								<td>{{$purchase->date_purchase}}</td>
                                <td>{{$purchase->book->name}}</td>
                                <td>{{$purchase->price}}</td>
                                <td>{{$purchase->member->name}}</td>
                            </tr>
                        @endforeach
					</tbody>
				</table>

			</div>
		</div>
		@endif
	</div>
</div>
@endsection