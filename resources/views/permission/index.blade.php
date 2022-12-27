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
                        <h4 class="card-title">User Role Table</h4>
                    </div>
                    <div>
                        @can('Role Create')
                        <a href="{{ route('permission.create') }}" class="btn btn-light btn-round">Add Role</a>
                        @endcan
                    </div>
                </div>
			  <div class="table-responsive mt-4">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Role Name</th>
                      <th scope="col">Guard Name</th>
                      @canany(['Role Edit', 'Role Delete'])
                      <th scope="col">Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($roles as $row)
                    <tr>
                      <th scope="row">{{$loop->index+1}}</th>
                      <td>{{ucfirst($row->name)}}</td>
                      <td>{{ucfirst($row->guard_name)}}</td>
                      @canany(['Role Edit', 'Role Delete'])
                      <td>
                        @can('Role Edit')
                          <a href="{{ route('permission.edit',$row->id) }}" class="btn btn-sm btn-success">Edit</a>
                        @endcan
                        @can('Role Delete')
                          <a href="{{ route('permission.delete',$row->id) }}" onclick="return confirm('Are you sure you want to delete this role ?');" class="btn btn-sm btn-danger">Delete</a>
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