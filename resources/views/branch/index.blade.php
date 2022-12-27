@extends('layouts.app')

@section('content')

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Branch Table</h4>
                    </div>
                    <div>
                        @can('Branch Create')
                        <a href="{{ route('branch.create') }}" class="btn btn-light btn-round">Add Branch</a>
                        @endcan
                    </div>
                </div>
			  <div class="table-responsive mt-4">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Total Employee</th>
                      @canany(['Branch Edit', 'Branch Delete'])
                      <th scope="col">Action</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($branchs as $key=> $branch)
                    <tr> 
                        <th scope="row">{{ $key+1 }}</th>
                        <td>{{ $branch->name }}</td>
                        <td>{{ \App\Models\User::where('branch_id', $branch->id)->count() }}</td>
                        
                        @canany(['Branch Edit', 'Branch Delete'])
                        <td>
                            @can('Branch Edit')
                            <a href="{{ route('branch.edit',$branch->id) }}" class="btn btn-sm btn-success">Edit</a>
                            @endcan
                            @can('Branch Delete')
                            <a href="{{ route('branch.delete',$branch->id) }}" class="btn btn-sm btn-danger">Delete</a>
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