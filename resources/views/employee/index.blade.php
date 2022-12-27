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
                        <h4 class="card-title">Employee Table</h4>
                    </div>
                    <div>
                        @can('Employee Create')
                        <a href="{{ route('employee.create') }}" class="btn btn-light btn-round">Add Employess</a>
                        @endcan
                    </div>
                </div>
			  <div class="table-responsive mt-4">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">User Id</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Department</th>
                      <th scope="col">Position</th>
                      <th scope="col">Role</th>
                      @canany(['Employee Edit', 'Employee Delete', 'Employee Profile'])
                      <th scope="col">Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  
                  <tbody>
                    @foreach($users as $key => $user)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ ucfirst($user->id) }}</td>
                      <td>{{ ucfirst($user->name) }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ ucfirst($user->department) }}</td>
                      <td>{{ ucfirst($user->position) }}</td>
                      <td>
                          @if($user->roles && count($user->roles) > 0)
                          {{ucfirst($user->roles[0]->name)}}
                          @else
                          {{'NOT DEFINED'}}
                          @endif
                       </td> 
                      @canany(['Employee Edit', 'Employee Delete', 'Employee Profile'])
                      <td>
                            @can('Employee Profile')
                            <a href="{{ route('employee.profile',$user->id) }}" class="btn btn-sm btn-info">Profile</a>
                            @endcan
                            @can('Employee Edit')
                            <a href="{{ route('employee.edit',$user->id) }}" class="btn btn-sm btn-success">Edit</a>
                            @endcan
                            @can('Employee Delete')
                            <a href="{{ route('employee.delete',$user->id) }}" onclick="return confirm('Are you sure you want to delete this User ?');" class="btn btn-sm btn-danger">Delete</a>
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