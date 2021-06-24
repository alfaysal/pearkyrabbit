@php
    
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();

@endphp


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('index') }}" class="brand-link">
      <span class="brand-text font-weight-light">Employee Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
  
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         

          <!-- ######################khoj the Search#################-->

          <li class="nav-item {{($prefix == '/Employee') ? 'menu-open':' '}}">
            <a href="#" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Employee
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ route('index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index</p>
                </a>
              </li>
              

            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>