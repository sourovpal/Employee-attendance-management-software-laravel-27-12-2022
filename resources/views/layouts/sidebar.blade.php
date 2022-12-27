<!--Start sidebar-wrapper-->
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
 <div class="brand-logo">
  <a href="{{ url('/') }}">
   <img src="{{ asset('frontend/assets/images/qsc2.svg') }}" class="logo-icon" alt="logo icon">
   <!--<h5 class="logo-text">Dashboard Name</h5>-->
 </a>
</div>
<ul class="sidebar-menu do-nicescrol">
  <li class="sidebar-header">MAIN NAVIGATION</li>
  @can('Dashboard View')
  <li>
    <a href="{{ url('/') }}">
      <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  @endcan
  @can('Branch View')
  <li>
    <a href="{{ route('branch.index') }}"> 
      <i class="zmdi zmdi-balance"></i><span>Branch</span>
    </a>
  </li>
  @endcan
  @can('Role View')

  <li>
      <a href="{{route('permission.index')}}">
          <i class="zmdi zmdi-lock"></i> <span>Role & Permission</span>
      </a>
  </li>
  @endcan
  @can('Employee View')
  <li>
    <a href="{{ route('employee.index') }}">
      <i class="zmdi zmdi-accounts-add"></i> <span>Employee</span>
    </a>
  </li>
  @endcan
  @can('Schedule View')
  <li>
    <a href="{{ route('schedule.index') }}">
      <i class="zmdi zmdi-grid"></i> <span>Schedule</span>
    </a>
  </li>
  @endcan
  @can('Attendance View')
  <li>
    <a href="{{ route('attendance.index') }}">
      <i class="zmdi zmdi-assignment"></i> <span>Attendance</span>
    </a>
  </li>
  
  @endcan
  @can('Profile View')

  <li>
    <a href="{{ route('employee.profile') }}">
      <i class="zmdi zmdi-face"></i> <span>Profile</span>
    </a>
  </li>
  @endcan

</ul>

</div>
<!--End sidebar-wrapper-->