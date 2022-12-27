<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Http\Resources\AttendanceResource;
use App\Models\Schedule;


class AttendanceController extends Controller
{
    
    private $user;
    public function __construct(){
        $this->middleware("auth");
        $this->middleware(function($request, $next){
            $this->user = auth()->user();
            return $next($request);
        });
    }
    
     public function index(){
        
        if($this->user->can('Attendance View')){
            if($this->user->can('All Access')){
                
                $collection = Attendance::orderBy('id', 'DESC')->get();
                $attendances = json_decode(AttendanceResource::collection($collection)->toJson(), true);
                return view('attendance.index', compact('attendances'));
                
            }elseif($this->user->can('Branch Access')){
                $branchid = auth()->user()->branch_id;
                
                $usersId = User::where('branch_id', $branchid )->pluck('id');
                
                $collection = Attendance::whereIn('user_id', $usersId)->orderBy('id', 'DESC')->get();
                
                $attendances = json_decode(AttendanceResource::collection($collection)->toJson(), true);
                
                return view('attendance.index', compact('attendances'));
                
            }
            
        }
        return abort('403');
    }
    
    public function clock(){
        if($this->user->can('Attendance Web Clock')){
            
            return view('attendance.clock');
            
        }
        return abort('403');
    }
    
    public function clock_submit(Request $request){
        
        if($this->user->can('Attendance Web Clock')){
            $user_id = $request->user_id;
            $time = $request->time;
            $date = $request->date;
            $action = $request->action;
            
            if($user_id == ''){
                return response()->json([
                    'message' => 'User ID field is required.',
                    'type' => 'error',
                ]);
            }
            
            if(User::find($user_id)){
                
                $attendance = Attendance::where('user_id', $user_id)->where('work_date', $date)->first();
                
                
                if($action == 'clock_in'){
                    
                    if(!$attendance && $action == 'clock_in'){
                        
                        $schedule = Schedule::where('user_id', $user_id)->where('status', 1)->first();
                        if($schedule){
                            $in_status = 1;
                            if(strtotime($time) <= strtotime($schedule->start_time)){
                                $in_status = 2;
                            }
                            
                            $data = [
                                'user_id' => $user_id,
                                'clock_in' => $time,
                                'work_date' => $date,
                                'in_status' => $in_status,
                            ];
                            
                            $attendance = Attendance::create($data);
                            if($attendance){
                                return response()->json([
                                    'message' => 'Attendance Clock in Successful.',
                                    'type' => 'success',
                                ]);
                            }else{
                                return response()->json([
                                    'message' => 'something went wrong please try again.',
                                    'type' => 'error',
                                ]);
                            }
                        }else{
                            return response()->json([
                                'message' => 'First make the schedule, then try again.',
                                'type' => 'error',
                            ]);
                            
                        }
                    }else{
                        return response()->json([
                            'message' => 'Clock in already Started.',
                            'type' => 'error',
                        ]);
                    }
                }
                //==========================================
                if($action == 'clock_out'){
                    if($attendance && $action == 'clock_out'){
                        $schedule = Schedule::where('user_id', $user_id)->where('status', 1)->first();
                        if($schedule){
                            $out_status = 1;
                            if($time && (strtotime($time) >= strtotime($schedule->end_time))){
                                $out_status = 2;
                            }
                            
                            $data = [
                                'clock_out' => $time,
                                'out_status' => $out_status,
                            ];
                            
                            $attendance->update($data);
                            return response()->json([
                                'message' => 'Attendance Clock out Successful.',
                                'type' => 'success',
                            ]);
                            
                        }else{
                            return response()->json([
                                'message' => 'First make the schedule, then try again.',
                                'type' => 'error',
                            ]);
                            
                        }
                    }else{
                        return response()->json([
                            'message' => 'Please at first start clock in then clock out',
                            'type' => 'error',
                        ]);
                    }
                }
                
            }else{
                return response()->json([
                        'message' => 'Invalid User ID',
                        'type' => 'error',
                    ]);
                
            }
        }
        return response()->json([
                        'message' => 'Whoops 403! THIS AREA IS FORBIDDEN. TURN BACK NOW!',
                        'type' => 'error',
                    ]);
    }
    
    public function create(){
        if($this->user->can('Attendance Create')){
            
            if($this->user->can('All Access')){
                
                $users = User::orderBy('id', 'DESC')->get();
                return view("attendance.create",compact('users'));
                
            }elseif($this->user->can('Branch Access')){
                $branchid = auth()->user()->branch_id;
                $users = User::where('branch_id', $branchid)->orderBy('id', 'DESC')->get();
                return view("attendance.create",compact('users'));
            }
            
            $users = User::orderBy('id', 'DESC')->get();
            return view("attendance.create",compact('users'));
        }
        return abort('403');
    }
    
    public function store(Request $request){
        if($this->user->can('Attendance Create')){
            $request->validate([
                "employee_name" => "required",
                "date" => "required|string",
                "clock_in" => "required|string",
                "clock_out" => "nullable|string",
            ]);
            $schedule = Schedule::where('user_id', $request->employee_name)->where('status', 1)->first();
            if($schedule){
                $in_status = 1;
                $out_status = 1;
                if(strtotime($request->clock_in) <= strtotime($schedule->start_time)){
                    $in_status = 2;
                }
                if($request->clock_out && (strtotime($request->clock_out) >= strtotime($schedule->end_time))){
                    $out_status = 2;
                }
                if(!$request->clock_out){
                    $out_status = 0;
                }
                
                $data = [
                    'user_id' => $request->employee_name,
                    'clock_in' => $request->clock_in,
                    'clock_out' => $request->clock_out,
                    'work_date' => $request->date,
                    'in_status' => $in_status,
                    'out_status' => $out_status,
                ];
                $checkAtt = Attendance::where('user_id', $request->employee_name)->whereDate('work_date', $request->date)->first();
                if($checkAtt){
                    $checkAtt->update(
                            [
                            'clock_out' => $request->clock_out,
                            'out_status' => $out_status,
                            ]);
                            return back()->withSuccess("Attendance Already Created, Please Edit.");
                }else{
                    $attendance = Attendance::create($data);
                    if($attendance){
                        return back()->withSuccess("Attendance Created Successful.");
                    }
                }
                return back()->withError("something went wrong please try again later");
            }
            return back()->withError("First make the schedule, then try again.");
        }
        return abort('403');
    }
    
    
    public function edit($id){
        if($this->user->can('Attendance Edit')){
            
            $attendance = Attendance::findOrFail($id);
            $users = User::orderBy('id', 'DESC')->get();
            return view("attendance.edit",compact('attendance', 'users'));
            
        }
        return abort('403');
    }
    
    public function update(Request $request){
        if($this->user->can('Attendance Edit')){
            
            $id = $request->id;
            $request->validate([
                "employee_name" => "required",
                "date" => "required|string",
                "clock_in" => "required|string",
                "clock_out" => "nullable|string",
            ]);
            $schedule = Schedule::where('user_id', $request->employee_name)->where('status', 1)->first();
            if($schedule){
                $in_status = 1;
                $out_status = 1;
                if(strtotime($request->clock_in) <= strtotime($schedule->start_time)){
                    $in_status = 2;
                }
                if($request->clock_out && (strtotime($request->clock_out) >= strtotime($schedule->end_time))){
                    $out_status = 2;
                }
                if(!$request->clock_out){
                    $out_status = 0;
                }
                
                $data = [
                    'user_id' => $request->employee_name,
                    'clock_in' => $request->clock_in,
                    'clock_out' => $request->clock_out,
                    'work_date' => $request->date,
                    'in_status' => $in_status,
                    'out_status' => $out_status,
                ];
                
                $attendance = Attendance::find($id);
                if($attendance){
                    $attendance->update($data);
                    return back()->withSuccess("Attendance Updated Successful.");
                }
                return back()->withError("something went wrong please try again later");
            }
            return back()->withError("First make the schedule, then try again.");
        }
        return abort('403');
    }
    
    public function delete(Request $request){
        if($this->user->can('Attendance Delete')){
            $id = $request->id;
            $attendance = Attendance::find($id);
            if($attendance){
                $attendance->delete();
                return back()->withSuccess("Attendance Deleted Successful.");
            }
            return back()->withError('Attendance not found!');
        }
        return abort('403');
    }
}
