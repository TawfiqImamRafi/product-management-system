<!-- sidebar menu -->
<div class="sidebar-area">
    <!-- Sidebar Menu -->
    <nav>
        <h4 class="nav-title">Navigation</h4>
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bx bx-cog"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="bx bx-cog"></i>
                    <span>Brand</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('brand.list') }}">List</a></li>
                </ul>
            </li>
            </li>
            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="bx bx-cog"></i>
                    <span>Category</span>
                    <i class='bx bx-chevron-down'></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('category.list') }}">Category</a></li>
                    <li><a href="{{ route('sub-category.list') }}">Sub Category</a></li>
                    <li><a href="{{ route('sub-sub-category.list') }}">Sub Sub Category</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('attribute.list') }}">
                    <i class="bx bx-cog"></i>
                    <span>Attribute</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
