<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Http\Resources\ScheduleResource;


class ScheduleController extends Controller
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
        if($this->user->can('Schedule View')){
            
            
            if($this->user->can('All Access')){
                
                $collection = Schedule::orderBy('id', 'DESC')->get();
                $schedules = json_decode(ScheduleResource::collection($collection)->toJson(), true);
                return view('schedule.index', compact('schedules'));
                
            }elseif($this->user->can('Branch Access')){
                $branchid = auth()->user()->branch_id;
                
                $usersId = User::where('branch_id', $branchid )->pluck('id');
                
                $collection = Schedule::whereIn('user_id', $usersId)->orderBy('id', 'DESC')->get();
                $schedules = json_decode(ScheduleResource::collection($collection)->toJson(), true);
                return view('schedule.index', compact('schedules'));
                
            }
            
        }
        return abort('403');
    }
    
    public function create(){
        if($this->user->can('Schedule Create')){
            if($this->user->can('All Access')){
                
                $users = User::orderBy('id', 'DESC')->get();
                return view("schedule.create",compact('users'));
                
            }elseif($this->user->can('Branch Access')){
                $branchid = auth()->user()->branch_id;
                $users = User::where('branch_id', $branchid)->orderBy('id', 'DESC')->get();
                return view("schedule.create",compact('users'));
            }
        }
        return abort('403');
    }
    
    public function store(Request $request){
        if($this->user->can('Schedule Create')){
            
            $request->validate([
                "employee_name" => "required|string",
                "from_date" => "required|string",
                "until_date" => "required|string",
                "start_time" => "required|string",
                "end_time" => "required|string",
                "rest_day" => "nullable",
            ]);
            
            Schedule::where('user_id', $request->employee_name)->update(['status'=> 0]);
            
            $data = [
                'user_id' => $request->employee_name,
                'from_date' => $request->from_date,
                'until_date' => $request->until_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'rest_days' => implode(', ', $request->rest_day??[]),
                'status' => 1,
            ];
            
            $schedule = Schedule::create($data);
            if($schedule){
                return back()->withSuccess("New Schedule Created Successful.");
            }
            return back()->withError("Something went wrong please try again later");
            
        }
        return abort('403');
    }
    
    
    public function edit($id){
        if($this->user->can('Schedule Edit')){
            
            $users = User::orderBy('id', 'DESC')->get();
            $schedule = Schedule::findOrFail($id);
            return view("schedule.edit",compact('schedule', 'users'));
            
        }
        return abort('403');
    }
    
    public function update(Request $request){
        if($this->user->can('Schedule Edit')){
            
            $id = $request->id;
            $request->validate([
                "employee_name" => "required|string",
                "from_date" => "required|string",
                "until_date" => "required|string",
                "start_time" => "required|string",
                "end_time" => "required|string",
                "rest_day" => "nullable",
            ]);
            
            Schedule::where('user_id', $request->employee_name)->update(['status'=> 0]);
            
            $data = [
                'user_id' => $request->employee_name,
                'from_date' => $request->from_date,
                'until_date' => $request->until_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'rest_days' => implode(', ', $request->rest_day??[]),
                'status' => 1,
            ];
            
            $schedule = Schedule::find($id);
            if($schedule){
                $schedule->update($data);
                return back()->withSuccess("Schedule Updated Successful.");
            }
            return back()->withError("something went wrong please try again later");
        }
        return abort('403');
    }
    
    public function delete(Request $request){
        if($this->user->can('Schedule Edit')){
            
            $id = $request->id;
            $schedule = Schedule::find($id);
            if($schedule){
                $schedule->delete();
                return back()->withSuccess("Schedule Deleted Successful.");
            }
            return redirect()->route('branch.index')->withError('Schedule not found!');
        }
        return abort('403');
    }
}
