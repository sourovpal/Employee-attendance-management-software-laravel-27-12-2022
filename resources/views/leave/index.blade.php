@extends('layouts.app')

@section('content')
    <style>
    #notifications-main{
        z-index:9999999999 !important;
    }
    </style>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          @include('message')
          <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">View Leave Request</h4>
                    </div>
                    <div>
                        @can('Leave Request Send')
                        <a href="#LeaveModal" data-toggle="modal" class="btn btn-light btn-round">Send Leave Request</a>
                        @endcan
                    </div>
                </div>
			  <div class="table-responsive mt-4">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th width="5%" scope="col">#</th>
                      <th width="10%" scope="col">Start Time</th>
                      <th width="10%" scope="col">End Time</th>
                      <th width="10%" scope="col">Total Hour</th>
                      <th width="50%" scope="col">Description</th>
                      <th width="10%" scope="col">Status</th>
                      <th width="10%" scope="col">Action</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    @foreach($leaves as $key => $leave)
                    <tr>
                      <th>{{ $key+1 }}</th>
                      <td>{{ $leave['start_time'] }}</td>
                      <td>{{ $leave['end_time'] }}</td>
                      <td>{{ $leave['total_hour'] }}</td>
                      <td>{{ $leave['description'] }}</td>
                      <td>
                            @if($leave['status'] == 0)
                                <span class="btn py-1 btn-sm btn-warning">{{__("Panding")}}</span>
                            @elseif($leave['status'] == 1)
                                <span class="btn py-1 btn-sm btn-success">{{ __("Approve") }}</span>
                            @else
                                <span class="btn py-1 btn-sm btn-danger">{{ __("Cencal") }}</span>
                            @endif
                      </td>
                      <td>
                          @if($leave['status'] != 1)
                              @can('Leave Request Approve')
                              <a class="btn btn-sm btn-success" href="{{route('leave.update', ['id' => $leave['id'], 'status'=> 1 ])}}">Approve</a>
                              @endcan
                          @endif
                          @if($leave['status'] != 2)
                              @can('Leave Request Approve')
                              <a class="btn btn-sm btn-warning" href="{{route('leave.update', ['id' => $leave['id'], 'status'=> 2 ])}}">Cencal</a>
                              @endcan
                          @endif
                          @if($leave['status'] == 0)
                          <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this leave request ?');" href="{{route('leave.delete', $leave['id'])}}">Delete</a>
                          @else
                          <button class="btn btn-sm btn-danger" disabled>Delete</a>
                          @endif
                      </td>
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
		<!-- Modal -->
        <div class="modal fade" id="LeaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Leave Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="leave_request_form" action="{{route('leave.store', request()->id)}}" method="POST">
                    @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Start Time</label>
                    <input type="time" class="form-control" name="start_time">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">End Time</label>
                    <input type="time" class="form-control" name="end_time">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
              <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
              </div>-->
            </div>
          </div>
        </div>

    </div>
    <!-- End container-fluid-->
    <script src="https://sourovpal.xyz/public/js/notifications.js"></script>
    <script>
        
        $('#leave_request_form').submit(function(e){
            e.preventDefault();
            $.ajax({
                url:this.action, 
                method:"POST",
                data:$(this).serialize(),
                beforeSend:function(res){
                    $.notification(
                        ["Please wait sometime"],
                        {
                            position: ['top', 'right'],
                            messageType: 'success',
                            timeView: 5000,
                        }
                    )
                },
                success:function(res){
                    $.notification(
                        [res.message],
                        {
                            position: ['top', 'right'],
                            messageType: res.type,
                            timeView: 5000,
                        }
                    )
                    if(res.type == 'sucess'){
                        window.location.reload(true);
                    }
                },
                error:function(res){
                    $.notification(
                        ["Something went wrong please try again"],
                        {
                            position: ['top', 'right'],
                            messageType: 'error',
                            timeView: 6000,
                        }
                    )
                },
            });
        });
        
    </script>
@endsection