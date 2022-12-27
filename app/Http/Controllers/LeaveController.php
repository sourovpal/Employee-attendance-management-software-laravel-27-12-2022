<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Leave;
use App\Http\Resources\LeaveResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    
    private $user;
    public function __construct(){
        $this->middleware("auth");
        $this->middleware(function($request, $next){
            $this->user = auth()->user();
            return $next($request);
        });
    }
    
    public function index(Request $request){
        if($this->user->canany(['Leave Request Send', 'Leave Request'])){
            $collection = Leave::where('attendance_id', $request->id)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
            $leaves = json_decode(LeaveResource::collection($collection)->toJson(), true);
            return view('leave.index',compact('leaves'));
        }
        return abort('403');
    }
    
    
    public function store(Request $request){
        if($this->user->can('Leave Request Send')){
            $id = $request->id;
            
            $validator = Validator($request->all(), [
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'description' => 'required',
                ]);
            
            if($validator->passes()){
                $user_id = Attendance::find($id)->user_id;
                $leave = Leave::create([
                        'user_id' => $user_id,
                        'attendance_id' => $id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'description' => $request->description,
                    ]);
                if($leave){
                    return response()->json([
                        'message' => 'Leave Request send successful!',
                        'type' => 'success',
                    ]);
                }
            }else{
                return response()->json([
                        'message' => $validator->errors()->first(),
                        'errors' => $validator->errors(),
                        'type' => 'error',
                    ]);
            }
            return response()->json([
                    'message' => 'Whoops 403! THIS AREA IS FORBIDDEN. TURN BACK NOW!',
                    'type' => 'error',
                ]);
        }
    }
    
    public function update(Request $request){
        if($this->user->can('Leave Request Approve')){
            
            $id = $request->id;
            $status = $request->status;
            $leave = Leave::find($id);
            if($leave){
                $leave->update(['status'=>$status]);
                if($status == 1){
                    return back()->withSuccess("Leave Request Approve!");
                }else{
                    return back()->withSuccess("Leave Request Cencal!");
                }
            }
        }
        
        return abort('403');
    }
    
    
    public function delete(Request $request){
        if($user->can('Leave Request Send')){
            $leave = Leave::find($request->id);
            if($leave){
                if($leave->status == 0){
                    $leave->delete();
                    return back()->withSuccess("Attendance Deleted Successful.");
                }elseif($leave->status == 1){
                    return back()->withError("Leave Request already Approved.");
                }else{
                    return back()->withError("Leave Request already Cancel.");
                }
            }
            return back()->withError('Leave Request not found!');
        }
    }
}
