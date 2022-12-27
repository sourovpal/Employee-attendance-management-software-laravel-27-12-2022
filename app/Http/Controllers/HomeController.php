<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Branch;
use App\Models\Leave;
use App\Http\Resources\LeaveResource;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->user = auth()->user();
            return $next($request);
        }); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if($this->user->can('Dashboard View')){
            
            $collection = Leave::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
            $leaves = json_decode(LeaveResource::collection($collection)->toJson(), true);
  
            
            
            $user = User::count();
            $attendance = Attendance::whereDate('work_date', Carbon::today())->count();
            $schedule = Schedule::count();
            $branch = Branch::count();
            
            $totalDay = date('t');
            $totalWorkDay  = 31;
            $totalRestDay  = 0;
            $totalPresent  = 0;
            $totalAbsent   = 0;
            $auth = auth()->user();
            
            $_schedule = Schedule::where('user_id', $auth->id)->where("status", 1)->first();
            
            if($_schedule){
                $restDays = array_map('trim', explode(',',  $_schedule->rest_days)??[]);
                
                $fridays = array();
    
                foreach($restDays as $day){
                    for($i=4; $i<=4; $i++){
                        $fridays[] = date('Y-m-d', strtotime("first $day of this month"));
                        $fridays[] = date('Y-m-d', strtotime("second $day of this month"));
                        $fridays[] = date('Y-m-d', strtotime("third $day of this month"));
                        if(date('Y', strtotime("fourth $day of this month")) == date('Y')){
                        $fridays[] = date('Y-m-d', strtotime("fourth $day of this month"));
                        }
                        if(date('Y', strtotime("fifth $day of this month")) == date('Y')){
                            $fridays[] = date('Y-m-d', strtotime("fifth $day of this month"));
                        }
                    }
                }
                
                $totalRestDay = count($fridays);
                $totalWorkDay  = $totalDay - $totalRestDay;
                $totalPresent = Attendance::where('user_id', $auth->id)->whereMonth("work_date", date('m'))->count();
                $totalAbsent = $totalWorkDay - $totalPresent;
            }
            
            return view('dashboard.index', compact('user','leaves','attendance','schedule','branch', 'totalDay', 'totalWorkDay', 'totalRestDay', 'totalPresent', 'totalAbsent'));
        }
        return abort('403');    
    }
}
