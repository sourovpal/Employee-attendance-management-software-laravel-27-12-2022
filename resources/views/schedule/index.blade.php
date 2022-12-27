@extends('layouts.app')

@section('content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          @include('message')
          <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Schedule Table</h4>
                    </div>
                    <div>
                        @can('Schedule Create')
                        <a href="{{ route('schedule.create') }}" class="btn btn-light btn-round">Add Schedule</a>
                        @endcan
                    </div>
                </div>
			  <div class="table-responsive mt-4">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">User ID</th>
                      <th scope="col">Employee</th>
                      <th scope="col">Start/Off Time</th>
                      <th scope="col">Total Hour</th>
                      <th scope="col">Rest Days</th>
                      <th scope="col">From</th>
                      <th scope="col">Until</th>
                      <th scope="col">Status</th>
                      @canany(['Add Attendance', 'Schedule Edit', 'Schedule Delete'])
                      <th scope="col">Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($schedules as $row)
                    <tr> 
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{ $row['user_id'] }}</td>
                        <td>{{ ucfirst($row['user_name']) }}</td>
                        <td>{{ $row['time'] }}</td>
                        <td>{{ $row['total_hour'] }}</td>
                        <td style="white-space: pre-wrap;">{{ ($row['rest_days'] != '')?$row['rest_days']:'-' }}</td>
                        <td>{{ $row['from_date'] }}</td>
                        <td>{{ $row['until_date'] }}</td>
                        <td>{{ ($row['status'] == 1)?'Active':'Inactive' }}</td>
                        @canany(['Add Attendance', 'Schedule Edit', 'Schedule Delete'])
                        <td>
                            @can('Add Attendance')
                                @if($row['status'] == 1)
                                <a href="{{ route('attendance.create', $row['user_id']) }}" class="btn btn-sm btn-info">Add Attendance</a>
                                @endif
                            @endcan
                            @can('Schedule Edit')
                            <a href="{{ route('schedule.edit', $row['id']) }}" class="btn btn-sm btn-success">Edit</a>
                            @endcan
                            @can('Schedule Delete')
                            <a onclick="return confirm('Are you sure you want to delete this schedule ?');" href="{{ route('schedule.delete', $row['id']) }}" class="btn btn-sm btn-danger">Delete</a>
                            @endcan
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            </div>
          </div>
        </div>
      </div><!--End Row-->
	  
	  <!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

    </div>
    <!-- End container-fluid-->

@endsection