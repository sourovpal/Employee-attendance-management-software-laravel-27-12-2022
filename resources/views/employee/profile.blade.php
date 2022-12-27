@extends('layouts.app')

@section('content')

<style>
    .no-drop{
        cursor:no-drop;
    }
</style>

<div class="container-fluid">

      <div class="row mt-3">
        <div class="col-lg-3">
           <div class="card profile-card-2">
            <div class="card-img-block" style="background-image:url({{asset('/img/cover.jpg')}});background-size: cover;background-repeat: no-repeat;background-position: top right;">
            </div>
            <div class="card-body pt-5">
                @if($user->avatar && $user->avatar != '')
                <img src="{{asset('img')}}/{{$user->avatar}}" alt="profile-image" class="profile" style="height: 75px;">
                @else
                <img src="https://via.placeholder.com/110x110" alt="profile-image" class="profile">
                @endif
                <h5 class="card-title mb-1 d-flex" style="font-size:22px;">{{ucwords($user->name)}} ( <p class="card-text text-success" style="font-size:16px;margin:0 1px;">{{ (count($user->roles) > 0)?ucwords($user->roles[0]->name):'Not Defined'}}</p> )</h5>
                <p class="card-text"><i class="icon-user" style="margin-left: -5px;"></i> <span class="mr-1" style="margin-left: -7px;">Member since:</span> {{$user->created_at->format("M d, Y")}}</p>
                <div class="icon-block">
                  <a href="javascript:void();"><i class="fa fa-facebook bg-facebook text-white"></i></a>
				  <a href="javascript:void();"> <i class="fa fa-twitter bg-twitter text-white"></i></a>
				  <a href="javascript:void();"> <i class="fa fa-google-plus bg-google-plus text-white"></i></a>
                </div>
            </div>
        </div>

        </div>

        <div class="col-lg-9">
           <div class="card">
            @include('message')
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                <li class="nav-item">
                    <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">Profile</span></a>
                </li>
                @if((auth()->user()->id == $user->id) && auth()->user()->can('Change Password'))
                <li class="nav-item">
                    <a href="javascript:void();" data-target="#password" data-toggle="pill" class="nav-link"><i class="zmdi zmdi-lock"></i> <span class="hidden-xs">Password</span></a>
                </li>
                @endif
                @if($user->can('Profile Schedule View'))
                <li class="nav-item">
                    <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i class="zmdi zmdi-grid"></i> <span class="hidden-xs">Schedule</span></a>
                </li>
                @endif
                @if($user->can('Profile Attendance View'))
                <li class="nav-item">
                    <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link"><i class="zmdi zmdi-assignment"></i> <span class="hidden-xs">Attendance</span></a>
                </li>
                @endif
            </ul>
            <div class="tab-content p-3">
                <div class="tab-pane active" id="profile">
                    <form @if($user->can('Profile Edit')) method="post" action="{{route('employee.profile.update')}}" enctype="multipart/form-data" @endif>
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">USER ID</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="text" value="{{$user->id}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Name</label>
                            <div class="col-lg-9">
                                <input class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" name="name" value="{{$user->name}}">
                                <span class="invalid-feedback">{{$errors->first('name')}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="email" name="email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Phone</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="text" value="{{$user->phone}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Change profile</label>
                            <div class="col-lg-9">
                                <input class="form-control {{$errors->has('profile_image')?'is-invalid':''}}" type="file" name="profile_image">
                                <span class="invalid-feedback">{{$errors->first('profile_image')}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Gender</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="text" value="{{$user->gender}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Civil</label>
                            <div class="col-lg-9">
                                <input class="form-control {{$errors->has('civil')?'is-invalid':''}}" type="text" name="civil" value="{{$user->civil}}">
                                <span class="invalid-feedback">{{$errors->first('civil')}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Age</label>
                            <div class="col-lg-9">
                                <input class="form-control {{$errors->has('age')?'is-invalid':''}}" type="" name="age" value="{{$user->age}}">
                                <span class="invalid-feedback">{{$errors->first('age')}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Date of Birth</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="date" value="{{$user->birth_date}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">National ID</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="text" value="{{$user->national_id}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">department</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="" value="{{$user->department}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">position</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="" value="{{$user->position}}">
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Branch</label>
                            <div class="col-lg-9">
                                <input class="form-control no-drop" readonly type="text" value="{{\App\Models\Branch::find($user->branch_id)?->name}}">
                            </div>
                        </div>
                        @if(auth()->user()->id == $user->id)
                        @if($user->can('Profile Edit'))
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="submit" class="btn btn-primary" value="Save Changes">
                            </div>
                        </div>
                        @endif
                        @endif
                    </form>
                    <!--/row-->
                </div>
                @if(auth()->user()->id == $user->id && $user->can('Change Password'))
                <div class="tab-pane" id="password">
                    <form method="post" action="{{route('employee.profile.password')}}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Old password</label>
                        <div class="col-lg-9">
                            <input class="form-control {{$errors->has('old_password')?'is-invalid':''}}" type="" name="old_password" value="{{old('old_password')}}">
                            <span class="invalid-feedback">{{$errors->first('old_password')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">New Password</label>
                        <div class="col-lg-9">
                            <input class="form-control {{$errors->has('new_password')?'is-invalid':''}}" type="" name="new_password" value="{{old('new_password')}}">
                            <span class="invalid-feedback">{{$errors->first('new_password')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                        <div class="col-lg-9">
                            <input class="form-control {{$errors->has('confirm_password')?'is-invalid':''}}" name="confirm_password" type="" value="{{old('confirm_password')}}">
                            <span class="invalid-feedback">{{$errors->first('confirm_password')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"></label>
                        <div class="col-lg-9">
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                    </form>
                </div>
                @endif
                @if($user->can('Profile Attendance View'))
                <div class="tab-pane" id="messages">
                    <div class="table-responsive mt-4">
                       <table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Date</th>
                              <th scope="col">Clock In</th>
                              <th scope="col">Clock Out</th>
                              <th scope="col">Total Hour</th>
                              <th scope="col">Leave Hour</th>
                              <th scope="col">Status</th>
                              @if($user->can('Leave Request') && auth()->user()->id == $user->id)
                              <th scope="col">Action</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($attendances as $row)
                            <tr> 
                                <td>{{$loop->index+1}}</td>
                                <td>{{$row['date']}}</td>
                                <td>{{$row['clock_in']}}</td>
                                <td>{{$row['clock_out']}}</td>
                                <td>{{$row['total_hour']}}</td>
                                <td>{{$row['leave_hour']}}</td>
                                <td>{!! $row['status'] !!}</td>
                                @if($user->can('Leave Request') && auth()->user()->id == $user->id)
                                <td>
                                    <a @if(date('d-m-Y') == date('d-m-Y', strtotime($row['work_date']))) href="{{ route('leave.index',$row['id']) }}"  @else style="background:#90a199;" title="Request time end"  @endif class="btn btn-sm btn-success">Leave</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @if($user->can('Profile Schedule View'))
                <div class="tab-pane" id="edit">
                    <div class="table-responsive mt-4">
                       <table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Start / Off Time</th>
                              <th scope="col">Total Hour</th>
                              <th scope="col">Rest Days</th>
                              <th scope="col">From</th>
                              <th scope="col">Until</th>
                              <th scope="col">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($schedules as $row)
                            <tr> 
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{{ $row['time'] }}</td>
                                <td>{{ $row['total_hour'] }}</td>
                                <td style="white-space: pre-wrap;">{{ ($row['rest_days'] != '')?$row['rest_days']:'-' }}</td>
                                <td>{{ $row['from_date'] }}</td>
                                <td>{{ $row['until_date'] }}</td>
                                <td>{{ ($row['status'] == 1)?'Active':'Inactive' }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
      </div>
      </div>
        
    </div>

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->
	
    </div>
@endsection