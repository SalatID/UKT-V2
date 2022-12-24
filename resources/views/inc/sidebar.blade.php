<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('home')}}" class="brand-link">
  <img src="{{asset('assets')}}/img/logo.png" alt="eInvoice" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light"><b>UKT </b>Online</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
           <img src="{{asset('assets')}}/img/user-logo.png" class="img-circle elevation-2 bg-white" alt="User Image">
        </div>
        <div class="info">
           <a href="#" class="d-block">{{auth()->user()->name}}</a>
           {{-- 
           <p class="text-white text-wrap col-12">{{\App\Models\EventMaster::where('id',auth()->user()->event_id)->first()->name??'No Event'}} {{\App\Models\EventMaster::where('id',auth()->user()->event_id)->first()->penyelenggara??'No Event'}}</p>
           --}}
        </div>
     </div>
     <!-- SidebarSearch Form -->
     {{-- 
     <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
           <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
           <div class="input-group-append">
              <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
              </button>
           </div>
        </div>
     </div>
     --}}
     <!-- Sidebar Menu -->
     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
           <li class="nav-item">
              <a href="{{route('home')}}" class="nav-link {{ url()->current() == route('home') ? 'active' : '' }}">
                 <i class="nav-icon fas fa-tachometer-alt"></i>
                 <p>
                    Dashboard
                 </p>
              </a>
           </li>
           <li class="nav-item">
              <a href="{{route('peserta')}}" class="nav-link {{ url()->current() == route('peserta') ? 'active' : '' }}">
                 <i class="nav-icon fas fa-user-friends"></i>
                 <p>
                    Peserta
                 </p>
              </a>
           </li>
           @if (auth()->user()->role==='SPADM')
           <li class="nav-item">
              <a href="{{route('kelompok')}}" class="nav-link {{ url()->current() == route('kelompok') ? 'active' : '' }}">
                 <i class="nav-icon fas fa-users"></i>
                 <p>
                    Kelompok
                 </p>
              </a>
           </li>
           @endif
           <li class="nav-item {{ explode('/', url()->current())[4] == 'nilai'  ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ explode('/', url()->current())[4] == 'nilai' ? 'active' : '' }}">
                 <i class="nav-icon fas fa-sort-numeric-up"></i>
                 <p>
                    Nilai
                    <i class="right fas fa-angle-left"></i>
                 </p>
              </a>
              <ul class="nav nav-treeview bg-secondary">
                 <li class="nav-item">
                    <a href="{{route('nilai')}}" class="nav-link {{ url()->current() == route('nilai') ? 'active' : '' }}">
                       <i class="nav-icon fas fa-sort-numeric-up"></i>
                       <p>
                          Nilai Awal
                       </p>
                    </a>
                 </li>
                 @if (auth()->user()->role==='SPADM')
                 <li class="nav-item">
                    <a href="{{route('summary-nilai')}}" class="nav-link {{ url()->current() == route('summary-nilai') ? 'active' : '' }}">
                       <i class="fas fa-trophy nav-icon"></i>
                       <p>Summary Nilai</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('cetak-sertifikat')}}" class="nav-link {{ url()->current() == route('cetak-sertifikat') ? 'active' : '' }}">
                       <i class="fas fa-certificate nav-icon"></i>
                       <p>Cetak Sertifikat</p>
                    </a>
                 </li>
                 @endif
              </ul>
           </li>
           {{-- 
           <li class="nav-item">
              <a href="{{route('invoice')}}" class="nav-link {{ url()->current() == route('invoice') ? 'active' : '' }}">
                 <i class="nav-icon fas fa-file-invoice"></i>
                 <p>
                    Invoice
                 </p>
              </a>
           </li>
           <li class="nav-item">
              <a href="{{route('payreceipt')}}" class="nav-link {{ url()->current() == route('payreceipt') ? 'active' : '' }}">
                 <i class="nav-icon fas fa-file-invoice-dollar"></i>
                 <p>
                    Kwitansi
                 </p>
              </a>
           </li>
           --}}
           @if (auth()->user()->role==='SPADM')
           <li class="nav-item {{ explode('/', url()->current())[4] == 'master' ? 'menu-open' : '' }} ">
              <a href="#" class="nav-link {{ explode('/', url()->current())[4] == 'master' ? 'active' : '' }}">
                 <i class="nav-icon fas fa-bars"></i>
                 <p>
                    Master 
                    <i class="right fas fa-angle-left"></i>
                 </p>
              </a>
              <ul class="nav nav-treeview bg-secondary">
                 <li class="nav-item">
                    <a href="{{route('master-komwil')}}" class="nav-link {{ url()->current() == route('master-komwil') ? 'active' : '' }}">
                       <i class="far fa-building nav-icon"></i>
                       <p>Master Komwil</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('master-unit')}}" class="nav-link {{ url()->current() == route('master-unit') ? 'active' : '' }}">
                       <i class="fas fa-school nav-icon"></i>
                       <p>Master Unit</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('master-ts')}}" class="nav-link {{ url()->current() == route('master-ts') ? 'active' : '' }}">
                       <i class="fas fa-spa nav-icon"></i>
                       <p>Master TS</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('master-jurus')}}" class="nav-link {{ url()->current() == route('master-jurus') ? 'active' : '' }}">
                       <i class="fas fa-walking nav-icon"></i>
                       <p>Master Jurus</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('master-penilai')}}" class="nav-link {{ url()->current() == route('master-penilai') ? 'active' : '' }}">
                       <i class="fas fa-user nav-icon"></i>
                       <p>Master Penilai</p>
                    </a>
                 </li>
              </ul>
           </li>
           <li class="nav-item {{ explode('/', url()->current())[3] == 'admin' && explode('/', url()->current())[4]!='home' && explode('/', url()->current())[4]!='peserta' && explode('/', url()->current())[4]!='master' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ explode('/', url()->current())[3] == 'admin' && explode('/', url()->current())[4]!='home' && explode('/', url()->current())[4]!='peserta' && explode('/', url()->current())[4]!='master' ? 'active' : '' }}">
                 <i class="nav-icon fas fa-cog"></i>
                 <p>
                    Admin
                    <i class="right fas fa-angle-left"></i>
                 </p>
              </a>
              <ul class="nav nav-treeview bg-secondary">
                 <li class="nav-item">
                    <a href="{{route('admin-user')}}" class="nav-link {{ url()->current() == route('admin-user') ? 'active' : '' }}">
                       <i class="fas fa-users nav-icon"></i>
                       <p>User Setting</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('admin-event')}}" class="nav-link {{ url()->current() == route('admin-event') ? 'active' : '' }}">
                       <i class="fas fa-calendar nav-icon"></i>
                       <p>Event</p>
                    </a>
                 </li>
                 <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-toolbox nav-icon"></i>
                     <p>
                        Tools
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{route('copy-data')}}" class="nav-link">
                           <i class="far fa-dot-circle nav-icon"></i>
                           <p>Copy Data</p>
                        </a>
                     </li>
                      <li class="nav-item">
                        <a href="{{route('formulir')}}" class="nav-link">
                           <i class="far fa-dot-circle nav-icon"></i>
                           <p>Form Penilaian Manual</p>
                        </a>
                     </li>
                     {{--<li class="nav-item">
                        <a href="#" class="nav-link">
                           <i class="far fa-dot-circle nav-icon"></i>
                           <p>Copy Kelompok</p>
                        </a>
                     </li>
                     <li class="nav-item">
                      <a href="#" class="nav-link">
                         <i class="far fa-dot-circle nav-icon"></i>
                         <p>Copy Peserta</p>
                      </a>
                   </li> --}}
                  </ul>
               </li>
                 <li class="nav-item">
                    <a href="{{route('admin-log')}}" class="nav-link {{ url()->current() == route('admin-log') ? 'active' : '' }}">
                       <i class="fas fa-history nav-icon"></i>
                       <p>Log Program</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{route('activity-log')}}" class="nav-link {{ url()->current() == route('activity-log') ? 'active' : '' }}">
                       <i class="fas fa-history nav-icon"></i>
                       <p>Activity Log</p>
                    </a>
                 </li>
              </ul>
           </li>
           @endif
        </ul>
     </nav>
     <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>