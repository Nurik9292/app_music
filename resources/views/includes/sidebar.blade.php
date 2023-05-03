<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('main')}}" class="brand-link">
      <img src="{{asset('admins/dist/img/AdminLTELogo.png')}}" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sanly Mukam</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Блоки
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('listen.index')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Слушать</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    {{-- <a href="#" class="nav-link"> --}}
                        <a href="{{route('overview.index', 'index')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Обзор</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('radio.index')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Радио</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="{{route('track.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-music"></i>
                  <p>
                    Треки
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('artist.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-user-circle"></i>
                  <p>
                    Артисты
                  </p>
                </a>
              </li>
              <i class="fas fa-music-slash"></i>
              <li class="nav-item">
                <a href="{{route('album.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-record-vinyl"></i>
                  <p>
                    Альбомы
                  </p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('playlist.index')}}" class="nav-link">
                  <i class="nav-icon far fa-file-audio"></i>
                  <p>
                    Плейлисты
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                  <i class="nav-icon fas fa-comments"></i>
                  <p>
                    Feedback
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('genre.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>
                    Жанры
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                  <i class="nav-icon fas fa-eye"></i>
                  <p>
                    Слешка за модератором
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('user.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                        Users
                 </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Настройки
                  </p>
                </a>
              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>