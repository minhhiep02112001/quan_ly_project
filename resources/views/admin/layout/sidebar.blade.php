<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('/admins/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p> Nguyễn Văn A</p>
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
        <li class="active treeview">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-th"></i> <span>Trang chủ</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('schedule.index') }}">
                <i class="fa fa-th"></i> <span>Lịch làm việc</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                </span>
            </a>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Dự án</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('project.index') }}"><i class="fa fa-circle-o"></i> Dự án</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Phạt</a></li>
                <li><a href="{{ route('target.index') }}"><i class="fa fa-circle-o"></i> Mục tiêu</a></li>

                <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Lịch làm việc
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Công việc</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Chi tiết thực hiện</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Hợp đồng
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('contract.index') }}"><i class="fa fa-circle-o"></i> Danh sách</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Chi tiết thực hiện</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Công việc
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('task.index') }}"><i class="fa fa-circle-o"></i> Công việc</a></li>

                    </ul>
                </li>
                <li><a href="{{ route('expense-management.index') }}"><i class="fa fa-circle-o"></i> Quản lý chi
                        phí</a></li>
                <li><a href="{{ route('people-involved.index') }}"><i class="fa fa-circle-o"></i> Người liên quan</a>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Danh mục tài sản dự án
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Danh sách</a></li>

                    </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Đề xuất</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Rủi ro</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-edit"></i> <span>Nhân viên</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Danh sách nhân viên</a>
                </li>

            </ul>
        </li>
    </ul>
</section>
