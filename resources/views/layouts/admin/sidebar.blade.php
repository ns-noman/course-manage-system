@php
use Illuminate\Support\Facades\DB;
$privileges = DB::table('privileges')
                ->join('menus', function ($join) {
                    $join->on('privileges.menu_id', '=', 'menus.id');
                })
                ->where('privileges.role_id', Auth::guard('admin')->user()->type)
                ->select('menus.menu_name')
                ->get()->toArray();
$privileges = array_column($privileges,'menu_name');
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-0 bg-dark">
    <a href="{{ url('admin/profile/update-admin-details') }}" class="brand-link bg-warning">
        <img src="{{ Auth::guard('admin')->user()->image? asset('public/uploads/admin/'. Auth::guard('admin')->user()->image): asset('public/frontend-assets/img/user.png') }}" alt="{{ $basicInfo->title }} Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8" height="30" width="30">
        <span class="brand-text font-weight-dark text-dark">{{ Str::ucfirst(Auth::guard('admin')->user()->name) }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Dashboard',$privileges)) --}}
                <li class="nav-item {{ request()->is('admin/dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- @endif --}}
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Basic Info Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/basic-infos*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/basic-infos') }}" class="nav-link {{ request()->is('admin/basic-infos*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Basic Info Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Admin',$privileges))
                {{-- <li class="nav-item {{ request()->is('admin/admin*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/admin*') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-edit"></i>
                      <p>
                        Admin
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Role Manage',$privileges))
                        <li class="nav-item">
                            <a href="{{ url('admin/admin/roles') }}" class="nav-link {{ request()->is('admin/admin/roles*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Role Manage</p>
                            </a>
                        </li>
                      @endif
                      @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Admin Manage',$privileges))
                        <li class="nav-item">
                            <a href="{{ url('admin/admin/admins') }}" class="nav-link {{ request()->is('admin/admin/admins*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Admin Manage</p>
                            </a>
                        </li>
                      @endif
                    </ul>
                </li> --}}
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Settings',$privileges))
                {{-- <li class="nav-item {{ request()->is('admin/profile/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/profile/*') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-edit"></i>
                      <p>
                        Settings
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Update Password',$privileges))
                        <li class="nav-item">
                            <a href="{{ url('admin/profile/update-admin-password') }}" class="nav-link {{ request()->is('admin/profile/update-admin-password*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Update Password</p>
                            </a>
                        </li>
                      @endif
                      @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Update Details',$privileges))
                        <li class="nav-item">
                            <a href="{{ url('admin/profile/update-admin-details') }}" class="nav-link {{ request()->is('admin/profile/update-admin-details*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Update Details</p>
                            </a>
                        </li>
                      @endif
                    </ul>
                </li> --}}
                @endif
                {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Catalogue Manage',$privileges))
                <li class="nav-item {{ request()->is('admin/catalogue/*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/catalogue/*') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-edit"></i>
                      <p>
                        Catalogue Manage
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Category',$privileges))
                            <li class="nav-item">
                                <a href="{{ url('admin/catalogue/categories') }}" class="nav-link {{ request()->is('admin/catalogue/categories*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category</p>
                                </a>
                            </li>
                        @endif
                        @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Sub Category',$privileges))
                            <li class="nav-item">
                                <a href="{{ url('admin/catalogue/sub-categories') }}" class="nav-link {{ request()->is('admin/catalogue/sub-categories*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sub Category</p>
                                </a>
                            </li>
                        @endif
                        @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Sub Child',$privileges))
                            <li class="nav-item">
                                <a href="{{ url('admin/catalogue/sub-child') }}" class="nav-link {{ request()->is('admin/catalogue/sub-child*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sub Child</p>
                                </a>
                            </li>
                        @endif
                        @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Color',$privileges))
                            <li class="nav-item">
                                <a href="{{ url('admin/catalogue/colors') }}" class="nav-link {{ request()->is('admin/catalogue/colors*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Color</p>
                                </a>
                            </li>
                        @endif
                        @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Size',$privileges))
                            <li class="nav-item">
                                <a href="{{ url('admin/catalogue/sizes') }}" class="nav-link {{ request()->is('admin/catalogue/sizes*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Size</p>
                                </a>
                            </li>
                        @endif
                        @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Product',$privileges))
                            <li class="nav-item">
                                <a href="{{ url('admin/catalogue/products') }}" class="nav-link {{ request()->is('admin/catalogue/products*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif --}}
                
                {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Order Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/orders') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Order Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Customer Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/customers*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/customers') }}" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Customer Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Today\'s Deal Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/deals') }}"
                            class="nav-link {{ request()->is('admin/deals*') ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-edit"></i></i>Today's Deal Manage</a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Home Feature Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/home-features') }}"
                            class="nav-link {{ request()->is('admin/home-features*') ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-edit"></i></i>Home Feature Manage</a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Blog Category Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/blog-category') }}" class="nav-link {{ request()->is('admin/blog-category*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Blog Category Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Blog Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/blogs') }}" class="nav-link {{ request()->is('admin/blogs*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Blog Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('About Us Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/about-us*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/about-us') }}" class="nav-link {{ request()->is('admin/about-us*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>About Us Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Slider Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/sliders*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/sliders') }}" class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Slider Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/reviews*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/reviews') }}" class="nav-link {{ request()->is('admin/reviews*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Review Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Coupons Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/coupons_manage') }}"
                            class="nav-link {{ request()->is('admin/coupons_manage*') ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-edit"></i></i>Coupons Manage</a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Message Manage',$privileges))
                    <li class="nav-item">
                        <a href="{{ url('admin/messages') }}" class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Message Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Service Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/services*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/services') }}" class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Service Manage</p>
                        </a>
                    </li>
                @endif --}}


                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/trainees*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/trainees') }}" class="nav-link {{ request()->is('admin/trainees*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Trainee Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/trainers*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/trainers') }}" class="nav-link {{ request()->is('admin/trainers*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Trainer Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/courses*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/courses') }}" class="nav-link {{ request()->is('admin/courses*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Course Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/batches*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/batches') }}" class="nav-link {{ request()->is('admin/batches*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Batch Manage</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/schedule*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/schedule/schedules*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Schedule Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Role Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/schedule/schedules') }}" class="nav-link {{ request()->is('admin/schedule/schedules*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Schedule</p>
                                  </a>
                              </li>
                            @endif
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Admin Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/schedule/calendar') }}" class="nav-link {{ request()->is('admin/schedule/calendar*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Calendar</p>
                                  </a>
                              </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/enrolles*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/enrolles') }}" class="nav-link {{ request()->is('admin/enrolles*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Enroll Entry</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/attendances*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/attendances') }}" class="nav-link {{ request()->is('admin/attendances*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/result*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/result*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Result Manage
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Role Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/result/result-entries') }}" class="nav-link {{ request()->is('admin/result/result-entries*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Result Entry</p>
                                  </a>
                              </li>
                            @endif
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Admin Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/result/certificates') }}" class="nav-link {{ request()->is('admin/result/certificates*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Certificate</p>
                                  </a>
                              </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/departments*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/departments') }}" class="nav-link {{ request()->is('admin/departments*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Department</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/designations*') ? 'menu-open' : '' }}">
                        <a href="{{ url('admin/designations') }}" class="nav-link {{ request()->is('admin/designations*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Designation</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/expense*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/expense*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Training Expense
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Role Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/expense/expense-heads') }}" class="nav-link {{ request()->is('admin/expense/expense-heads*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Expense Head</p>
                                  </a>
                              </li>
                            @endif
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Admin Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/expense/expenses') }}" class="nav-link {{ request()->is('admin/expense/expenses*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expenses</p>
                                  </a>
                              </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Review Manage',$privileges))
                    <li class="nav-item {{ request()->is('admin/reports*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>All Report<i class="fas fa-angle-left right"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Role Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/reports/training-reports') }}" class="nav-link {{ request()->is('admin/reports/training-reports*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Training Report</p>
                                  </a>
                              </li>
                            @endif
                            @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Admin Manage',$privileges))
                              <li class="nav-item">
                                  <a href="{{ url('admin/reports/training-expense-reports') }}" class="nav-link {{ request()->is('admin/reports/training-expense-reports*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expense Report</p>
                                  </a>
                              </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<aside class="control-sidebar control-sidebar-dark"></aside>
