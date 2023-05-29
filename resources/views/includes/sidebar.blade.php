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
               @can('view', auth()->user())
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
              @endcan

              @can('view', auth()->user())
              <li class="nav-item">
                <a href="{{route('track.index', 'index')}}" class="nav-link">
                  <i class="nav-icon fas fa-music"></i>
                  <p>
                    Треки
                  </p>
                </a>
              </li>
              @endcan


              @can('view', auth()->user())
              <li class="nav-item">
                <a href="{{route('artist.index', 'index')}}" class="nav-link">
                    <i class="nav-icon fas fa-user-circle"></i>
                  <p>
                    Артисты
                  </p>
                </a>
              </li>
              @endcan

              @can('view', auth()->user())
              <li class="nav-item">
                <a href="{{route('album.index', 'index')}}" class="nav-link">
                    <i class="nav-icon fas fa-record-vinyl"></i>
                  <p>
                    Альбомы
                  </p>
                </a>
              </li>
              @endcan

              @can('view', auth()->user())
              <li class="nav-item">
                <a href="{{route('playlist.index', 'index')}}" class="nav-link">
                  <i class="nav-icon far fa-file-audio"></i>
                  <p>
                    Плейлисты
                  </p>
                </a>
              </li>
              @endcan

              @can('view', auth()->user())
              <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                  <i class="nav-icon fas fa-comments"></i>
                  <p>
                    Feedback
                  </p>
                </a>
              </li>
              @endcan

              @can('view', auth()->user())
              <li class="nav-item">
                <a href="{{route('genre.index', 'index')}}" class="nav-link">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>
                    Жанры
                  </p>
                </a>
              </li>
              @endcan

              @can('view', auth()->user())
              @if(auth()->user()->role !== 3)
              <li class="nav-item">
                <a href="{{route('moder.index', 'index')}}" class="nav-link">
                  <i class="nav-icon fas fa-eye"></i>
                  <p>
                    Запрос от модератора
                  </p>
                </a>
              </li>
              @endif
              @endcan

              @cannot('view', auth()->user())
              <li class="nav-item">
                  <a href="{{route('user.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Users
                    </p>
                </a>
            </li>
            @endcannot

            @can('view', auth()->user())
              <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Настройки
                  </p>
                </a>
              </li>
            @endcan
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
