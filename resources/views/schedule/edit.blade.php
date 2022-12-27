@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-selection--multiple {
            border: solid transparent 1px !important;
            outline: 0;
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        .select2-dropdown{
            background:#202534 !important;
        }
        .select2-selection__choice{
            background:#003761 !important;
        }
        .select2-results__option:hover,
        .select2-results__option--selected{
            background-color: #5897fb !important;
            color: white;
        }
    </style>
    <div class="container-fluid">

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Edit Schedule</h4>
                    </div>
                    <div>
                        <a href="{{ route('schedule.index') }}" class="btn btn-light btn-round">View Schedule</a>
                    </div>
                </div>
                <hr>
                <form action="{{route('schedule.update', $schedule->id)}}" method="POST">
                    
                   @include('message')
                    
                    @csrf
                    <div class="form-group">
                        <label for="input-6">Employee</label>
                        <select name="employee_name" class="form-control {{$errors->has('employee_name')?'is-invalid':''}}">
                            <option value="" hidden>Choose Name</option>
                            @foreach($users as $user)
                                <option @if($user->id == $schedule->user_id) selected @endif value="{{$user->id}}">{{ ucfirst($user->name ) }} - [{{$user->id}}]</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">{{$errors->first('employee_name')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="input-6">From Date</label>
                                <input type="date" name="from_date" class="form-control {{$errors->has('from_date')?'is-invalid':''}}" id="input-6" value="{{$schedule->from_date}}">
                                <span class="invalid-feedback">{{$errors->first('from_date')}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="input-6">Until Date</label>
                                <input type="date" name="until_date" class="form-control {{$errors->has('until_date')?'is-invalid':''}}" id="input-6" value="{{$schedule->until_date}}">
                                <span class="invalid-feedback">{{$errors->first('until_date')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="input-6">Start Time</label>
                                <input type="time" name="start_time" class="form-control {{$errors->has('start_time')?'is-invalid':''}}" id="input-6" value="{{$schedule->start_time}}">
                                <span class="invalid-feedback">{{$errors->first('start_time')}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="input-6">End Time</label>
                                <input type="time" name="end_time" class="form-control {{$errors->has('end_time')?'is-invalid':''}}" id="input-6" value="{{$schedule->end_time}}">
                                <span class="invalid-feedback">{{$errors->first('end_time')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-6">Rest Day</label>
                        <select name="rest_day[]" class="form-control select_2" multiple>
                            @php
                            $days = ['Friday','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday'];
                            @endphp
                            @foreach($days as $day)
                                <option @if(in_array($day, array_map('trim', explode(',',  $schedule->rest_days)??[]))) selected @endif  value='{{$day}}'>{{$day}}</option>
                            @endforeach                
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light btn-round px-5">Update</button>
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
    <script>
        
        $(function(){
            $(".select_2").select2({
              placeholder: 'Select Rest Day'
            });
        })();
        
    </script>
@endsection