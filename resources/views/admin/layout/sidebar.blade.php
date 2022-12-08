<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('/admins/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p> {{auth()->user()->name}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @if (\Illuminate\Support\Facades\Gate::allows('role', ['role' => ['admin']]))
            <li class="active">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-th"></i> <span>Trang chủ</span>
                    <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                </span>
                </a>
            </li>
        @endif
        <li>
            <a href="{{ route('schedule.index') }}">
                <i class="fa fa-th"></i> <span>Lịch làm việc</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                </span>
            </a>
        </li>
        <li><a href="{{ route('project.index') }}"><i class="fa fa-th"></i> Dự án</a></li>
        @if (\Illuminate\Support\Facades\Gate::allows('role', ['role' => ['admin']]))
            <li><a href="{{route('task.index')}}"><i class="fa fa-th"></i> Công việc</a></li>
            <li><a href="{{route('employee.index')}}"><i class="fa fa-th"></i> Nhân viên</a></li>
            <li><a href="{{route('customer.index')}}"><i class="fa fa-th"></i> Khách hàng</a></li>
        @endif
    </ul>
</section>
