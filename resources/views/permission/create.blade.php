@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Add Role</h4>
                    </div>
                    <div>
                        <a href="{{ route('permission.index') }}" class="btn btn-light btn-round">View Role</a>
                    </div>
                </div>
                <hr>
                <form action="{{route('permission.store')}}" method="post">
                    
                   @include('message')
                    @csrf
                    <div class="form-group">
                        <label for="input-6">Role Name</label>
                        <input type="text" name="name" class="form-control form-control-rounded {{$errors->has('name')?'is-invalid':''}}" id="input-6" placeholder="Enter Role Name" value="{{old('name')}}">
                        <span class="invalid-feedback">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light btn-round px-5"><i class="icon-lock"></i> Save Change</button>
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