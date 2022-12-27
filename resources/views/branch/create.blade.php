@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Add Branch</h4>
                    </div>
                    <div>
                        <a href="{{ route('branch.index') }}" class="btn btn-light btn-round">View Branch</a>
                    </div>
                </div>
                <hr>
                <form action="{{route('branch.store')}}" method="POST">
                    
                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
                      <strong>Error: </strong> {{Session::get('error')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif
                    
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
                      <strong>Message: </strong> {{Session::get('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif
                    
                    @csrf
                    <div class="form-group">
                        <label for="input-6">Branch Name</label>
                        <input type="text" name="name" class="form-control form-control-rounded {{$errors->has('name')?'is-invalid':''}}" id="input-6" placeholder="Enter Employee Name" value="{{old('name')}}">
                        <span class="invalid-feedback">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light btn-round px-5"><i class="icon-lock"></i> Submit</button>
                    </div>
                </form>
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