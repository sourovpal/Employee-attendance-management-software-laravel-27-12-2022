@extends('layouts.app')

@section('content')
<style>
.col-xl-3.border-light{
    background: #ffffff0f;
}
</style>
<div class="container-fluid">
  <!--Start Dashboard Content-->
  <div class="card mt-3">
    @include('message')
    <div class="card-content">
        
      <div class="row row-group m-0">
        @can('Total Employee')
        <div class="col-12 col-lg-6 col-xl-3 border-light">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $user }}<span class="float-right"><i class="zmdi zmdi-accounts-add"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:55%"></div>
            </div>
            <p class="mb-0 text-white small-font">Total Employee</p>
          </div>
        </div>
        @endcan
        @can('Today Attends')
        <div class="col-12 col-lg-6 col-xl-3 border-light">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $attendance }}<span class="float-right"><i class="zmdi zmdi-assignment"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:55%"></div>
            </div>
            <p class="mb-0 text-white small-font">Today Attends</p>
          </div>
        </div>
        @endcan
        @can('Today Absent')
        <div class="col-12 col-lg-6 col-xl-3 border-light">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $user -  $attendance }} <span class="float-right"><i class="zmdi zmdi-grid"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:55%"></div>
            </div>
            <p class="mb-0 text-white small-font">Today Absent</p>
          </div>
        </div>
        @endcan
        @can('Total Employee')
        <div class="col-12 col-lg-6 col-xl-3 border-light">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $branch }} <span class="float-right"><i class="zmdi zmdi-balance"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:55%"></div>
            </div>
            <p class="mb-0 text-white small-font">Branch</p>
          </div>
        </div>
        @endcan
        
        </div>
        <div class="row row-group m-0">
        
        <!---->
        @can('Employee Work Day')
        <div class="col-12 col-lg-6 col-xl-3 border-light mt-3">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $totalWorkDay }} / {{$totalDay}}<span class="float-right"><i class="zmdi zmdi-walk"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:{{ ((100/$totalDay)*$totalWorkDay) }}%"></div>
            </div>
            <p class="mb-0 text-white small-font">Total Work Day</p>
          </div>
        </div>
        @endcan
        @can('Employee Total Present')
        <div class="col-12 col-lg-6 col-xl-3 border-light mt-3">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $totalPresent }} / {{$totalWorkDay}}<span class="float-right"><i class="zmdi zmdi-assignment"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:{{ ((100/$totalWorkDay)*$totalPresent) }}%"></div>
            </div>
            <p class="mb-0 text-white small-font">Total Present</p>
          </div>
        </div>
        @endcan
        @can('Employee Total Absent')
        <div class="col-12 col-lg-6 col-xl-3 border-light mt-3">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $totalAbsent }} / {{ $totalWorkDay }}<span class="float-right"><i class="zmdi zmdi-grid"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:{{ ((100/$totalWorkDay)*$totalAbsent) }}%"></div>
            </div>
            <p class="mb-0 text-white small-font">Total Absent or Due</p>
          </div>
        </div>
        @endcan
        @can('Employee Total Rest Day')
        <div class="col-12 col-lg-6 col-xl-3 border-light mt-3">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $totalRestDay }} / {{$totalDay}}<span class="float-right"><i class="zmdi zmdi-balance"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
              <div class="progress-bar" style="width:{{ ((100/$totalDay)*$totalRestDay) }}%"></div>
            </div>
            <p class="mb-0 text-white small-font">Total Rest Day</p>
          </div>
        </div>
        @endcan
        
        
      </div>
      <!-- row -->
      
    </div>
  </div>
  
    @can('Leave Request View')
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-header">Today Leave Request</div>
          <div class="table-responsive">
            <table class="table table-striped">
                  <thead>
                    <tr>
                      <th width="5%" scope="col">#</th>
                      <th width="10%" scope="col">Start Time</th>
                      <th width="10%" scope="col">End Time</th>
                      <th width="10%" scope="col">Total Hour</th>
                      <th width="50%" scope="col">Description</th>
                      <th width="10%" scope="col">Status</th>
                      <th width="10%" scope="col">Action</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    @foreach($leaves as $key => $leave)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $leave['start_time'] }}</td>
                      <td>{{ $leave['end_time'] }}</td>
                      <td>{{ $leave['total_hour'] }}</td>
                      <td>{{ $leave['description'] }}</td>
                      <td>
                            @if($leave['status'] == 0)
                                <span class="btn py-1 btn-sm btn-warning">{{__("Panding")}}</span>
                            @elseif($leave['status'] == 1)
                                <span class="btn py-1 btn-sm btn-success">{{ __("Approve") }}</span>
                            @else
                                <span class="btn py-1 btn-sm btn-danger">{{ __("Cencal") }}</span>
                            @endif
                      </td>
                      <td>
                          @if($leave['status'] != 1)
                              @can('Leave Request Approve')
                              <a class="btn btn-sm btn-success" href="{{route('leave.update', ['id' => $leave['id'], 'status'=> 1 ])}}">Approve</a>
                              @endcan
                          @endif
                          @if($leave['status'] != 2)
                              @can('Leave Request Approve')
                              <a class="btn btn-sm btn-warning" href="{{route('leave.update', ['id' => $leave['id'], 'status'=> 2 ])}}">Cencal</a>
                              @endcan
                          @endif
                          @can('Leave Request Delete')
                          <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this leave request ?');" href="{{route('leave.delete', $leave['id'])}}">Delete</a>
                          @endcan
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
          </div>
        </div>
      </div>
      </div><!--End Row-->
      <!--End Dashboard Content-->
      @endcan
      <!--start overlay-->
      <div class="overlay toggle-menu"></div>
      <!--end overlay-->
</div>
<!-- End container-fluid-->
@endsection
