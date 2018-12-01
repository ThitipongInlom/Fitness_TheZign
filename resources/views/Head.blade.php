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
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <a class="nav-link" href="{{ url('/Logout') }}" data-toggle="tooltip" data-placement="bottom" title="ออกจากระบบ">ออกจากระบบ</a>
        </form>
    </div>
</nav>
<br>
