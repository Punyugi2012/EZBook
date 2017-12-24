<nav class="navbar navbar-light bg-light justify-content-between fixed-top" style="background-color:#808080!important">
	<span>
		<a class="navbar-brand" href="/" style="color:white"><h2><i class="fa fa-book" aria-hidden="true"></i> EZBooks</h2></a>
	</span>
	<span>
		<form action="/user-search-book" method="get"style="display:inline" autocomplete="off">
			{{ csrf_field() }}
			<div class="input-group">
				<input type="text" name="search" class="form-control" placeholder="ค้นหาหนังสือ">
				<span class="input-group-btn">
					<button class="btn btn-secondary" type="submit">ค้นหา</button>
				</span>
			</div>
		</form>
	</span>
	<span>
		<div class="btn-group" style="margin-right:5px;width:200px">
			<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:inherit!important">
				หนังสือ
			</button>
			<div class="dropdown-menu dropdown-menu-right" style="width:inherit!important">
				@foreach($bookTypes as $type)
					<a class="dropdown-item" href="/user-books/{{$type->id}}">{{$type->name}}</a>
				@endforeach
			</div>
		</div>
		@if(session()->has('user'))
			<a href="/user-logout" class="btn btn-warning float-right">ออกจากระบบ</a>
			<div class="dropdown float-right" style="margin-right:5px;width:200px">
				<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:inherit!important">
					ข้อมูลผู้ใช้
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenu2" style="width:inherit!important">
					<a class="dropdown-item disabled" href="javascript:void(0)">สวัสดี, {{session()->get('user')->member->name}}</a>
					<a class="dropdown-item" href="/user-profile">ข้อมูลส่วนตัว</a>
					<a class="dropdown-item" href="/user-books">หนังสือของคุน</a>
				</div>
			</div>
		@else
			<div class="dropdown float-right" style="margin-right:5px;width:200px">
				<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:inherit!important">
					เข้าสู่ระบบ
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenu2" style="width:inherit!important">
					<a class="dropdown-item" href="/user-login">ผู้ใช้</a>
					<a class="dropdown-item" href="/publisher-login">สำนักพิมพ์/นักเขียน</a>
					<a class="dropdown-item" href="/admin-login">แอดมิน</a>
				</div>
			</div>
		@endif
	</span>
</nav>