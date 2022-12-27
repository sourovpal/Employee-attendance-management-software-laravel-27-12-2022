@extends('layouts.app')

@section('content')
    <script src="{{asset('js/notifications.js')}}"></script>
    <div class="container-fluid">
        <div class="row" style="height: 100vh !important;">
            <div class="col-lg-5 col-xl-4 col-md-6 col-sm-6 align-self-center mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="clock-content text-center">
                            <h3>Workday</h3>
                            <p id="date" class="mt-2">Mon, July 12, 2022</p>
                            <h1 id="time" class="mt-1">11:09:23 PM</h1>
                            <div class="clock-form">
                                <div>
                                    <div class="form-group">
                                        <label for="ID">Enter User ID Number</label>
                                        <input id="user_id" type="text" class="form-control" placeholder="ID Number"> 
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <button type="submit" class="btn btn-success btn-round px-5 clock_in">Clock In</button>
                                            <button type="submit" class="btn btn-danger btn-round px-5 clock_out">Clock Out</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	    <div class="overlay toggle-menu"></div>
    </div>
<script>
    
    function get_date(){
        
        let objectDate = new Date();
        let weekday = objectDate.toLocaleString('default', { weekday: 'short' });
        let day = objectDate.getDate();
        let month = objectDate.toLocaleString('default', { month: 'short' });
        let year = objectDate.getFullYear();
        document.getElementById('date').innerHTML = `${weekday}, ${month} ${day}, ${year}`;
        
        var now = objectDate.toLocaleTimeString();
        document.getElementById('time').innerHTML = now;
        
    }
    setInterval(function(){
        get_date();
    }, 1000);
    get_date();
    
    function webclock(action){
        let objectDate = new Date();
        let day = objectDate.getDate();
        let month = objectDate.toLocaleString('default', { month: 'numeric' });
        let year = objectDate.getFullYear();
        var date = `${year}-${month}-${day}`;
        var time = objectDate.toLocaleTimeString("en-US", {hour: 'numeric', minute: '2-digit', hour12: false });
        var user_id = $('#user_id').val();
        var _token = '{{csrf_token()}}';
        console.log({
                _token,
                user_id,
                time,
                date,
                action
            });
        $.ajax({
            url:'{{route('attendance.clock.submit')}}',
            method:'POST',
            data:{
                _token,
                user_id,
                time,
                date,
                action
            },
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
                        timeView: 8000,
                    }
                )
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
        
    }
    
    
    $('.clock_in').click(function(){
        webclock('clock_in');
    });
    $('.clock_out').click(function(){
        webclock('clock_out');
    });
    
    
    
</script>
@endsection