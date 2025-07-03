<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ ('/') }}">
                <img class="img-fluid for-light" src="{{ asset('assets') }}/images/logo/logo.png" width="25%" alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ ('/') }}">
                <div class="icon-box-sidebar"><i data-feather="grid"></i></div>
            </a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-list"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard') }}"><i data-feather="home"></i><span class="">Dashboard</span></a>
                    </li>
                    <li class="sidebar-list"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="zap"></i><span class="">Data Kontingen</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('table.atlet') }}">Atlet</a></li>
                            <li><a href="{{ ('#') }}">Coach</a></li>
                            <li><a href="{{ ('#') }}">Official</a></li>
                            <li><a href="{{ ('#') }}">Pencarian</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="airplay"></i><span class="">Data Pertandingan</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ ('#') }}">Daftarkan</a></li>
                            <li><a href="{{ ('#') }}">Wasit</a></li>
                            <li><a href="{{ route('view.schedule.index') }}">Jadwal</a></li>
                            <li><a href="{{ ('#') }}">Laporan</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('view.venue.index') }}"><i data-feather="map"> </i><span>Data Venue</span></a></li>
                    <li class="sidebar-list"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="archive"></i><span class="">Data Unit Lokal</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ ('#') }}">Transportasi</a></li>
                            <li><a href="{{ ('#') }}">Penginapan</a></li>
                            <li><a href="{{ ('#') }}">Konsumsi</a></li>
                            <li><a href="{{ route('view.sport.index') }}">Cabang Olahraga</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="users"></i><span class="">Data Admin</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ ('#') }}">Panita Lokal</a></li>
                            <li><a href="{{ ('#') }}">Panitia Besar</a></li>
                            <li><a href="{{ ('#') }}">Wasit Pertandingan</a></li>
                            <li><a href="{{ ('#') }}">Admin Lain</a></li>
                        </ul>
                    </li>



                    <li class="sidebar-list"></i><a class="sidebar-link sidebar-title link-nav" href="support-ticket.html"><i data-feather="info"> </i><span>Log Aktivitas</span></a></li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>