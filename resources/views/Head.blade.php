@if (Session::has('Login'))
@else
<script>
    window.location = "{{ url('/') }}";
</script>
@endif
<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ url('/Dashboard') }}">Z-Fitness TheZign</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <form class="form-inline" action="{{ url('/CheckIn') }}" method="post" accept-charset="utf-8">
            @csrf
            <input class="form-control form-control-sm mr-sm-2" name="inputcode" type="text" placeholder="Check-in">
            <button class="btn btn-sm btn-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
          </form>
          <button style="margin-left:10px;" class="btn btn-sm btn-danger" onclick="Find_the_name_Modal();" data-toggle="tooltip" data-placement="bottom" title="ค้นหารายชื่อลูกค้า">ค้นหาชื่อ</button>
          <button style="margin-left:10px;" class="btn btn-sm btn-warning" onclick="Find_thezign_name_Modal();" data-toggle="tooltip" data-placement="bottom" title="ค้นหารายชื่อลูกค้าTheZign">ลูกค้าTheZign</button>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto" style="font-size:13px;">
          <li>
          <a class="nav-link" href="#"><b>รายงาน:</b></a>
          </li>
          <!-- MemberOnline -->
          <li>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">MemberOnline: {{ MainUsers::Get_Total_UserIn(2) }} คน <i class="fas fa-arrow-down"></i></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">ประเภทของ Member ที่มาใช้บริการ</span>
              @foreach (MainUsers::Get_Data_UserIn(2) as $key => $row)
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" style="color: #6c757d !important;">
                  <i class="fa fa-users mr-2"></i> {{ $row->type }}
                  <span class="float-right text-muted text-sm">{{ $row->total_type }} คน</span>
                </a>
              @endforeach
            </div>
          </li>
          </li>
          <!-- Memberใช้งานวันนี้ -->
          <li>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">Memberใช้งานวันนี้: {{ MainUsers::Get_Total_UserIn(1) }} คน <i class="fas fa-arrow-down"></i></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">ประเภทของ Member ที่มาใช้บริการ</span>
              @foreach (MainUsers::Get_Data_UserIn(1) as $key => $row)
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" style="color: #6c757d !important;">
                  <i class="fa fa-users mr-2"></i> {{ $row->type }}
                  <span class="float-right text-muted text-sm">{{ $row->total_type }} คน</span>
                </a>
              @endforeach
            </div>
          </li>
          </li>
          <!-- Memberใช้งานเมื่อวาน -->
          <li>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">Memberใช้งานเมื่อวาน: {{ MainUsers::Get_Total_UserIn(0) }} คน <i class="fas fa-arrow-down"></i></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">ประเภทของ Member ที่มาใช้บริการ</span>
              @foreach (MainUsers::Get_Data_UserIn(0) as $key => $row)
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" style="color: #6c757d !important;">
                  <i class="fa fa-users mr-2"></i> {{ $row->type }}
                  <span class="float-right text-muted text-sm">{{ $row->total_type }} คน</span>
                </a>
              @endforeach
            </div>
          </li>
          </li>
          <li>
            <a class="nav-link" href="{{ url('/Logout') }}" data-toggle="tooltip" data-placement="bottom" title="ออกจากระบบ">ออกจากระบบ</a>
          </li>
        </ul>
    </div>
</nav>
<br>
