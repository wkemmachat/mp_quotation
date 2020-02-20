<aside class="main-sidebar ">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }} </p>
          <a href="#"><i class="fa fa-circle åtext-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      {{--  <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>  --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>


        <!-- only Sales -->

        {{-- <li class="{{ Request::is('stock_real_time*') ? 'active' : '' }}">
            <a href="{{ route('stock_real_time') }}">
              <i class="fa fa-inbox"></i> <span>Stock</span>
            </a>
        </li> --}}


        {{-- @if(Auth::user()->user_type=='root'||Auth::user()->user_type=='admin')

        <li class="{{ Request::is('transfer_in_not_approve*') ? 'active' : '' }}">
            <a href="{{ route('transfer_in') }}">
              <i class="fa fa-sign-in"></i> <span>Transfer In / รับสินค้าเข้า</span>
            </a>
        </li>

        <li class="{{ Request::is('transfer_in_approve*') ? 'active' : '' }}">
            <a href="{{ route('transfer_in_approve') }}">
              <i class="fa fa-check-square"></i> <span>Transfer In Approved </span>
            </a>
        </li>

        <li class="{{ Request::is('transfer_out_not_approve*') ? 'active' : '' }}">
            <a href="{{ route('transfer_out') }}">
              <i class="fa fa-sign-out"></i> <span>Transfer Out / ส่งสินค้าออก</span>
            </a>
        </li>

        <li class="{{ Request::is('transfer_out_approve*') ? 'active' : '' }}">
            <a href="{{ route('transfer_out_approve') }}">
              <i class="fa fa-check-square-o"></i> <span>Transfer Out Approved </span>
            </a>
        </li>
        @endif --}}

        @if(Auth::user()->user_type=='root')

        <li class="{{ Request::is('category*') ? 'active' : '' }}">
            <a href="{{ route('category') }}">
              <i class="fa fa-bars"></i> <span>Category</span>
            </a>
        </li>

        <li class="{{ Request::is('product*') ? 'active' : '' }}">
            <a href="{{ route('product') }}">
              <i class="fa fa-archive"></i> <span>Product</span>
            </a>
        </li>

        <li class="{{ Request::is('upload*') ? 'active' : '' }}">
            <a href="{{ route('upload') }}">
              <i class="fa fa-cloud-upload"></i> <span>Upload</span>
            </a>
        </li>

        <li class="{{ Request::is('customer*') ? 'active' : '' }}">
            <a href="{{ route('customer') }}">
              <i class="fa fa-user-plus"></i> <span>Customer</span>
            </a>
        </li>

        @endif

        <li class="{{ Request::is('quotation*') ? 'active' : '' }}">
            <a href="{{ route('quotation') }}">
              <i class="fa fa-building-o"></i> <span>Quotation</span>
            </a>
        </li>

        {{--  <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>  --}}

        @can('isRoot')
        <li class="treeview {{ Request::is('user*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-users"></i> <span>Manage User</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ Request::is('user/manageUser*') ? 'active' : '' }}"><a href="{{ route('user') }}"><i class="fa fa-circle-o"></i>  User</a></li>
                {{--  <li class="{{ Request::is('user/role*') ? 'active' : '' }}"><a href="{{ route('role') }}"><i class="fa fa-circle-o"></i>  Role</a></li>  --}}
                {{--  <li class="{{ Request::is('user/manageRole_user*') ? 'active' : '' }}"><a href="{{ route('role_user') }}"><i class="fa fa-circle-o"></i>  Role_User</a></li>  --}}
            </ul>
        </li>
        @endcan

        {{--  <li class="{{ Request::is('category*') ? 'active' : '' }}">
            <a href="{{ route('category') }}">
              <i class="fa fa-bars"></i> <span>Category</span>
            </a>
        </li>  --}}

        {{--  {{ ($userSelected->roles->contains($role->id))? "checked" : ""  }}
        @if( Auth::user()->roles->contains($role->id) )  --}}

        <?php
            $canShow = false;
            foreach(Auth::user()->roles as $role){
                if(strcasecmp($role->title ,'qc')==0){
                    $canShow = true;
                    break;
                }
            }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/qc*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','qc') }}">
              <i class="fa fa-delicious"></i> <span>QC</span>
            </a>
        </li>
        @endif

        <?php
            $canShow = false;
            foreach(Auth::user()->roles as $role){
                if(strcasecmp($role->title ,'production')==0){
                    $canShow = true;
                    break;
                }
            }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/production*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','production') }}">
              <i class="fa fa-cubes"></i> <span>Production</span>
            </a>
        </li>
        @endif

        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'logistic')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/logistic*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','logistic') }}">
              <i class="fa fa-rocket"></i> <span>Logistic</span>
            </a>
        </li>
        @endif

        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'store')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/store*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','store') }}">
              <i class="fa fa-suitcase"></i> <span>Store</span>
            </a>
        </li>
        @endif

        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'planning')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/planning*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','planning') }}">
              <i class="fa fa-map"></i> <span>Planning</span>
            </a>
        </li>
        @endif


        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'online_sales_support')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/online_sales_support*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','online_sales_support') }}">
              <i class="fa fa-map-pin"></i> <span>Online_Sales_Support</span>
            </a>
        </li>
        @endif


        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'offline_sales_support')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/offline_sales_support*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','offline_sales_support') }}">
              <i class="fa fa-map-o"></i> <span>Offline_Sales_Support</span>
            </a>
        </li>
        @endif

        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'finished_goods_stock')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/finished_goods_stock*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','finished_goods_stock') }}">
              <i class="fa fa-gg"></i> <span>Finished_Goods_Stock</span>
            </a>
        </li>
        @endif


        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'raw_material_stock')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/raw_material_stock*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','raw_material_stock') }}">
              <i class="fa fa-gg-circle"></i> <span>Raw_Material_Stock</span>
            </a>
        </li>
        @endif


        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'design')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/design*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','design') }}">
              <i class="fa fa-industry"></i> <span>Design</span>
            </a>
        </li>
        @endif


        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'online_stock')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/online_stock*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','online_stock') }}">
              <i class="fa fa-registered"></i> <span>Online_Stock</span>
            </a>
        </li>
        @endif

        <?php
        $canShow = false;
        foreach(Auth::user()->roles as $role){
            if(strcasecmp($role->title ,'project_sales')==0){
                $canShow = true;
                break;
            }
        }
        ?>
        @if($canShow)
        <li class="{{ Request::is('kpi_output/project_sales*') ? 'active' : '' }}">
            <a href="{{ route('kpi_output','project_sales') }}">
              <i class="fa fa-adjust"></i> <span>Project_Sales</span>
            </a>
        </li>
        @endif

{{--
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li>
          <a href="../widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">Hot</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="../tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="../calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="../mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li class="active"><a href="blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>


        --}}



    </ul>



    </section>
    <!-- /.sidebar -->
  </aside>
