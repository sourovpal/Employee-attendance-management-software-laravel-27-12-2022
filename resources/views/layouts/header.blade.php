<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    @can('Attendance Web Clock')
    <li class="nav-item mr-5">
        <a href="{{route('attendance.clock')}}" class="btn btn-success btn-round">Web Clock</a>
    </li>
    @endcan
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile">
            @if(auth()->user()->avatar && auth()->user()->avatar != '')
            <img src="{{asset('img')}}/{{auth()->user()->avatar}}" class="img-circle" alt="user avatar">
            @else
            <img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar">
            @endif
        </span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="{{route('employee.profile')}}">
           <div class="media">
             <div class="avatar">
                 @if(auth()->user()->avatar && auth()->user()->avatar != '')
                 <img class="align-self-start mr-3" src="{{asset('img')}}/{{auth()->user()->avatar}}" alt="user avatar">
                 @else
                 <img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar">
                @endif
            </div>
            <div class="media-body">
            <h6 class="mt-2 user-title">{{ ucwords(auth()->user()->name) }} - <span class="text-success">{{ (count(auth()->user()->roles) > 0)?ucwords(auth()->user()->roles[0]->name):'Not Defined'}}</span></h6>
            <p class="user-subtitle">{{ auth()->user()->email }}</p>
            </div>
           </div>
          </a>
        </li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><a href="{{route('employee.profile')}}"><i class="icon-wallet mr-2"></i> Profile</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-power mr-2"></i>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->