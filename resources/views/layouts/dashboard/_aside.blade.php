 
          
     

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="pull-left image">
          <img src="{{ asset('dashboard_files/img/user2-160x160.jpg') }}" class="img-circle elevation-2" >
        </div>  
          <div class="pull-left info">
            <p>Mohamed Monia</p>
            <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
          </div>
      </div>

      <!-- Sidebar Menu -->
      
        <ul class="sidbar-menu" data-widget="tree" >
          
          <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-th"></i><span>@lang('site.dashboard')</span></a></li>

          @if(Auth::user()->hasPermission('categories_read'))

          <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-th"></i><span>@lang('site.categories')</span></a></li>
         
          @endif

          @if(Auth::user()->hasPermission('products_read'))

          <li><a href="{{ route('dashboard.products.index') }}"><i class="fa fa-th"></i><span>@lang('site.products')</span></a></li>
         
          @endif
          
          @if(Auth::user()->hasPermission('clients_read'))

          <li><a href="{{ route('dashboard.clients.index') }}"><i class="fa fa-th"></i><span>@lang('site.clients')</span></a></li>
         
          @endif

          @if(Auth::user()->hasPermission('orders_read'))

          <li><a href="{{ route('dashboard.orders.index') }}"><i class="fa fa-th"></i><span>@lang('site.orders')</span></a></li>
         
          @endif

          @if(Auth::user()->hasPermission('users_read'))

          <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-th"></i><span>@lang('site.users')</span></a></li>
         
          @endif
          
          
        </ul>
      
      <!-- /.sidebar-menu -->
      
    </div>
    <!-- /.sidebar -->
  </aside>

  
  
    
    
    
    
  </aside>
  <!-- /.control-sidebar -->