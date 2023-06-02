<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('main')}}" class="nav-link">Главная</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto mr-3" >

        <li class="nav-item d-none d-sm-inline-block">
            {{-- <form action="{{route('logout')}}" method="POST">
                @csrf
                <input type="submit"  rel="logout" class="nav-link" value="Выход">
            </form> --}}
            <a href="{{route('logout')}}" rel="logout" class="nav-link">Выход</a>
          </li>

    </ul>
  </nav>

