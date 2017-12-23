@extends('web.templates.app') @section('title', 'Dashboard') @section('header')
@include('web.components.headerThird')
@endsection @section('content')
<style>
	.nav li {
		margin-left: 5px;
	}
</style>
<div style="margin-top:20px">
	<ul class="nav nav-pills flex-column flex-sm-row" style="">
		<li class="nav-item">
			<a class="nav-link btn btn-info {{$isDashboard ? 'active' : ''}}" href="/publisher-dashboard"><h5>สรุป</h5></a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-info {{$isBooks ? 'active' : ''}}" href="/publisher-books"><h5>หนังสือทั้งหมด</h5></a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-info {{$isProfile ? 'active' : ''}}" href="/publisher-profile"><h5>ข้อมูลส่วนตัว</h5></a>
		</li>
		<li class="nav-item">
			<a class="nav-link btn btn-info {{$isHistory ? 'active' : ''}}" href="/publisher-history"><h5>ประวัติการขาย</h5></a>
		</li>
	</ul>
	@if (session()->has('publisher-login'))
		<div class="alert alert-success text-center" style="margin-top:10px">
			{{session()->get('publisher-login')}}
		</div>
	@endif
	<div style="margin-bottom:60px;margin-top:10px">
		@if($isDashboard)
		<div class="card" style="margin-top:20px">
			<div class="card-body">
				<h3 class="card-title">ยอดการขายรวม</h3>
				<p class="card-text"><a href="javascript:void(0)">{{$total}}</a> บาท</p>
				<h3 class="card-title">หนังสือที่คนอ่านมากที่สุด</h3>
				@if($topBook)
					<div class="text-center">
						<a href="/publisher-book/{{$topBook->id}}">
							<img class="border border-secondary rounded" src="{{$topBook->url_cover_image}}" alt="cover image" style="width:150px;height:200px"
							/>
						</a>
						<p style="margin-top:10px">ชื่อหนังสือ: {{$topBook->name}}</p>
						<p>คะแนน: {{$topBook->score}}</p>
						<p>ราคา: {{$topBook->price == 0 ? 'ฟรี' : $topBook->price.' บาท'}}</p>
						<p>ราคาสุทธิ: {{$topBook->price - ($topBook->price * ($topBook->discount_percent / 100))}} บาท</p>
						<p>สถานะ:
							<span class="{{$topBook->status == 'able' ? 'text-success' : 'text-danger'}}">{{$topBook->status == 'able' ? 'วางขาย' : 'ไม่วางขาย'}}</span>
						</p>
						<p>จำนวนคนอ่าน: {{$topBook->num_read}}</p>
					</div>
				@endif
			</div>
		</div>
		@elseif($isBooks)
		<div class="card">
			<div class="card-header">
				<span style="font-size:20px">
				@if($isSearch)
					คุณได้ค้นหา <a href="javascript:void(0)">{{$search}}</a>, พบ <a href="javascript:void(0)">{{$numOfBook}}</a> เล่ม
				@else
					ทั้งหมด
					<a href="javascript:void(0)">{{$numOfBook}}</a> เล่ม
				@endif
				</span>
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
									<div class="col-md-3 text-center">
										<a href="/publisher-book/{{$book->id}}">
											<img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:150px;height:200px"
											/>
										</a>
										<p style="margin-top:10px">ชื่อหนังสือ: {{$book->name}}</p>
										<p>คะแนน: {{$book->score}}</p>
										<p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.' บาท'}}</p>
										<p>ราคาสุทธิ: {{$book->price - ($book->price * ($book->discount_percent / 100))}} บาท</p>
										<p>สถานะ:
											<span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขายอยู่' : 'ยังไม่วางขาย'}}</span>
										</p>
										<p>จำนวนคนอ่าน: {{$book->num_read}}</p>
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
			<div class="card-body">
				<h3 class="card-title">ชื่อสำนักพิมพ์/นักเขียน</h3>
				<p class="card-text" style="margin-left:20px">{{session()->get('publisher')->publisher->name}}</p>
				<h3 class="card-title">ที่อยู่</h3>
				<p class="card-text" style="margin-left:20px">{{session()->get('publisher')->publisher->address}}</p>
				<h3 class="card-title">เบอร์โทรศัพท์</h3>
				<p class="card-text" style="margin-left:20px">{{session()->get('publisher')->publisher->phone}}</p>
				<h3 class="card-title">สถานะ</h3>
				<p class="card-text" style="margin-left:20px"><span class="{{session()->get('publisher')->publisher->status == 'able' ? 'text-success' : 'text-danger'}}">{{session()->get('publisher')->publisher->status == 'able' ? 'สัญญายังไม่หมด' : 'หมดสัญญาแล้ว'}}</span></p>
			</div>
		</div>
		@elseif($isHistory)
		<div class="card">
			<div class="card-header">
				<span style="font-size:20px">
				ประวัติการขาย, จำนวน <a href="javascript:void(0)">{{count($purchases)}}</a> รายการ
				</span>
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
                                <td><a href="/publisher-book/{{$purchase->book->id}}">{{$purchase->book->name}}</a></td>
                                <td>{{$purchase->price}} บาท</td>
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