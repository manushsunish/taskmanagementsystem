<aside
    style="background: linear-gradient(-120deg, #5c5c5c, #12191c, #2b3944, #000000);"
    class="main-sidebar elevation-4">
  <!-- Brand Logo -->
  <div class="brand-link">
    <h4 style="
    color: #fff;
    font-weight: 400 !important;" class="brand-text font-weight-light ml-4">
      Project Management
    </h4>
  </div>

  <!-- Sidebar -->
  <div class="sidebar" >
    <!-- Sidebar user panel (optional) -->
      <hr style="background:rgba(255,255,255,0.62);">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
              <img src="{{ asset('asset/dist/img/avatar04.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
              <a href="#" class="d-block text-success">
                  <h4 class="text-bold">{{ auth()->user()->name }}</h4>
              </a>
          </div>
      </div>
      <hr style="background:rgba(255,255,255,0.62);">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(auth()->user()->role === 'staff')
          <li class="nav-item">
              <a href="{{ route('staff.assigned.projects') }}" class="nav-link text-white">
                  <i class="nav-icon fas fa-project-diagram"></i>
                  <p>
                      Assigned Projects
                  </p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('staff.assigned.tasks') }}" class="nav-link text-white">
                  <i class="nav-icon fas fa-clipboard-check"></i>
                  <p>
                      Assigned Tasks
                  </p>
              </a>
          </li>
        @endif
        @if(auth()->user()->role === 'admin')
          <li class="nav-item">
              <a href="{{ route('admin.dashboard.index') }}" class="nav-link text-white">
                  <i class="nav-icon fas fa-home"></i>
                  <p>
                      Dashboard
                  </p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('admin.tasks.index') }}" class="nav-link text-white">
                  <i class="nav-icon fas fa-clipboard-check"></i>
                  <p>
                      Tasks
                  </p>
              </a>
          </li>
          <li class="nav-item">
              <a href="#" class="nav-link text-white">
                  <i class="nav-icon fas fa-project-diagram"></i>
                  <p>
                      Projects
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('admin.projects.create') }}" class="nav-link text-white">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Add Project</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('admin.projects.index') }}" class="nav-link text-white">
                          <i class="far fa-circle nav-icon"></i>
                          <p>All Project</p>
                      </a>
                  </li>
              </ul>
          </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Users
                    </p>
                </a>
            </li>
        @endif
        <li class="nav-item text-bold">
          <a href="{{ route('logout') }}"
          onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="nav-link text-danger">
            <i class="nav-icon fa fa-power-off"></i>
            <p>
              Logout
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
