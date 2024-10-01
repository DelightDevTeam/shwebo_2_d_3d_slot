<div class="fixed-plugin ">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2  ">
        <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg pt-5 card_design" style="background-color: rgb(6, 9, 27); height : 500px;">
        <ul class="navbar-nav pt-5 mt-3 ps-lg-5 ps-md-4 ps-sm-2 ps-2  pb-5">
            {{-- kzt --}}
            @can('two_d_access')
                {{-- @can('two_d_all_win')
                    <li class="nav-item active ">
                        <a class="nav-link text-white font " href="{{ url('admin/2-d-agent-all-winner') }}">
                            <span class="sidenav-mini-icon "> 2D </span>
                            <span class="sidenav-normal  ms-2  ps-1 ">ပေါက်သူများ </span>
                        </a>
                    </li>
                @endcan --}}
                @can('admin_access')
                    <li class="nav-item">
                        <a class="nav-link text-white font" href="{{ url('admin/2d-default-limit') }}">
                            <span class="sidenav-mini-icon  "> 2D </span>
                            <span class="sidenav-normal  ms-2  ps-1 "> DefaultLimit-သတ်မှတ်ရန် </span>
                        </a>
                    </li>
                @endcan
                @can('admin_access')
                    <li class="nav-item">
                        <a class="nav-link text-white font" href="{{ url('admin/2d-users-limit-cor') }}">
                            <span class="sidenav-mini-icon "> 2D </span>
                            <span class="sidenav-normal  ms-2  ps-1 "> ထိုးသားဘရိတ်/ကော်-သတ်မှတ်ရန် </span>
                        </a>
                    </li>
                @endcan
                @can('admin_access')
                    <li class="nav-item">
                        <a class="nav-link text-white font " href="{{ url('admin/close-2d-digit') }}">
                            <span class="sidenav-mini-icon "> 2D </span>
                            <span class="sidenav-normal  ms-2  ps-1 "> စိတ်ကြိုက်ဂဏန်းပိတ်ရန် </span>
                        </a>
                    </li>
                @endcan
                @can('admin_access')
                    <li class="nav-item">
                        <a class="nav-link text-white font" href="{{ url('admin/close-head-2d-digit') }}">
                            <span class="sidenav-mini-icon "> 2D </span>
                            <span class="sidenav-normal  ms-2  ps-1 "> ထိပ်စီးသုံးလုံးပိတ်ရန် </span>
                        </a>
                    </li>
                @endcan
            @endcan

            @can('three_d_access')
                    <li class="nav-item">
                        <a class="nav-link text-white font" href="{{ url('admin/3d-users-limit-cor')}}">
                            <span class="sidenav-mini-icon "> 3D </span>
                            <span class="sidenav-normal  ms-2  ps-1 "> ထိုးသားဘရိတ်/ကော်-သတ်မှတ်ရန် </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white font" href="{{ url('admin/3d-close-digit') }}">
                            <span class="sidenav-mini-icon ">3D</span>
                            <span class="sidenav-normal  ms-2  ps-1 ">စိတ်ကြိုက်ဂဏန်းပိတ်ရန်</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white font" href="{{ url('admin/3d-default-limits') }}">
                            <span class="sidenav-mini-icon ">3D</span>
                            <span class="sidenav-normal  ms-2  ps-1 ">Default-ဘရိတ်သတ်မှတ်ရန်</span>
                        </a>
                    </li>
            @endcan
        </ul>
    </div>
</div>
