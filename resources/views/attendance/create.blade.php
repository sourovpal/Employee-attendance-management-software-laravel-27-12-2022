@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Add Attendance</h4>
                    </div>
                    <div>
                        <a href="{{ route('attendance.index') }}" class="btn btn-light btn-round">View Attendance</a>
                    </div>
                </div>
                <hr>
                <form action="{{route('attendance.store')}}" method="POST">
                    
                    @include('message')
                    
                    @csrf
                    <div class="form-group">
                        <label for="input-6">Employee</label>
                        <select name="employee_name" class="form-control {{$errors->has('employee_name')?'is-invalid':''}}">
                            <option value="" hidden>Choose Name</option>
                            @foreach($users as $user)
                                <option 
                            @if($user->id == old('employee_name')) 
                                selected
                            @elseif(!old('employee_name') && $user->id == request()->id) 
                                selected 
                            @endif 
                            value="{{ $user->id }}">{{ ucfirst($user->name) }} - [ {{ ucfirst($user->id) }} ]</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">{{$errors->first('employee_name')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="input-6">Date</label>
                        <input type="date" name="date" class="form-control form-control-rounded {{$errors->has('date')?'is-invalid':''}}" id="input-6" placeholder="Enter Employee Name" value="{{old('date')}}">
                        <span class="invalid-feedback">{{$errors->first('date')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="input-6">Clock In</label>
                                <input type="time" name="clock_in" class="form-control form-control-rounded {{$errors->has('clock_in')?'is-invalid':''}}" id="input-6" value="{{old('clock_in')}}">
                                <span class="invalid-feedback">{{$errors->first('clock_in')}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="input-6">Clock Out <span style="color: #ffee21;">( optional )</span></span></label>
                                <input type="time" name="clock_out" class="form-control form-control-rounded {{$errors->has('clock_out')?'is-invalid':''}}" id="input-6" value="{{old('clock_out')}}">
                                <span class="invalid-feedback">{{$errors->first('clock_out')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light btn-round px-5">Submit</button>
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