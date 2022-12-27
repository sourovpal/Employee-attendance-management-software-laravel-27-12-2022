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
                        <h4 class="card-title">Attendance Table</h4>
                    </div>
                    <div>
                        @can('Attendance Web Clock')
                        <a href="{{ route('attendance.clock') }}" class="btn btn-success btn-round">Web Clock</a>
                        @endcan
                        @can('Attendance Create')
                        <a href="{{ route('attendance.create') }}" class="btn btn-light btn-round">Add Attendance</a>
                        @endcan
                    </div>
                </div>
			  <div class="table-responsive mt-4">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">user id</th>
                      <th scope="col">Date</th>
                      <th scope="col">Employee</th>
                      <th scope="col">Clock In</th>
                      <th scope="col">Clock Out</th>
                      <th scope="col">Total Hour</th>
                      <th scope="col">Leave Hour</th>
                      <th scope="col">Status</th>
                      @canany(['Attendance Edit', 'Attendance Delete', 'Attendance Leave'])
                      <th scope="col">Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($attendances as $row)
                    <tr> 
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$row['user_id']}}</td>
                        <td>{{$row['date']}}</td>
                        <td><a href="{{route('employee.edit', ['id'=>$row['user_id']])}}">{{ucfirst($row['user_name'])}}</td>
                        <td>{{$row['clock_in']}}</td>
                        <td>{{$row['clock_out']}}</td>
                        <td>{{$row['total_hour']}}</td>
                        <td>{{$row['leave_hour']}}</td>
                        <td>{!! $row['status'] !!}</td>
                      @canany(['Attendance Edit', 'Attendance Delete', 'Attendance Leave'])
                        <td>
                            @can('Attendance Leave')
                            <a href="{{ route('leave.index', $row['id']) }}" class="btn btn-sm btn-warning">Leave</a>
                            @endcan
                            @can('Attendance Edit')
                            <a href="{{ route('attendance.edit', $row['id']) }}" class="btn btn-sm btn-success">Edit</a>
                            @endcan
                            @can('Attendance Delete')
                            <a onclick="return confirm('Are you sure you want to delete this attendance ?');" href="{{ route('attendance.delete', $row['id']) }}" class="btn btn-sm btn-danger">Delete</a>
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