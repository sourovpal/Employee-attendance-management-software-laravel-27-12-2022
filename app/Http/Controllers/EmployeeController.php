<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\ScheduleResource;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class EmployeeController extends Controller
{
    //
    private $user;
    public function __construct(){
        $this->middleware("auth");
        $this->middleware(function($request, $next){
            $this->user = auth()->user();
            return $next($request);
        });
    }
    
    public function index(){
        
        if($this->user->can('Employee View')){
            
            if($this->user->can('All Access')){
                
                $users = User::orderBy('id', 'desc')->get();
                return view('employee.index',compact('users'));
                
            }elseif($this->user->can('Branch Access')){
                $branch_id = auth()->user()->branch_id;
                if($branch_id > 0){
                    $users = User::where('branch_id', $branch_id)->orderBy('id', 'desc')->get();
                    return view('employee.index',compact('users'));
                }
                
            }
        }
        return abort('403');
    }
    
    
    public function create(){
        if($this->user->can('Employee Create')){
            return view('employee.create');
        }
        return abort('403');
    }
    
    public function store(Request $request){
        if($this->user->can('Employee Create')){
            
            $request->validate([
                'name' => 'required|string|min:2|max:50',
                'email' => 'required|string|max:100|unique:users,email',
                'phone' => 'required|max:20|unique:users,phone',
                'gender' => 'required|max:20',
                'civil' => 'required|max:20',
                'birth_date' => 'required|max:20',
                'age' => 'required|integer',
                'national_id' => 'required|max:25|unique:users,national_id',
                'department' => 'required|string|max:50',
                'position' => 'required|string|max:50',
                'role' => 'required|string',
                'branch' => 'required',
                'password' => 'required|string|min:6|max:50',
                'confirm_password' => 'required_with:password|same:password|max:50',
            ]);
            
            $data = [
                    'branch_id' => $request->branch,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'civil' => $request->civil,
                    'birth_date' => $request->birth_date,
                    'age' => $request->age,
                    'national_id' => $request->national_id,
                    'department' => $request->department,
                    'position' => $request->position,
                    'password' => bcrypt($request->password),
                ];
            
            $user = User::create($data);
            if($user){
                $user->assignRole($request->role);
                return back()->withSuccess("New Employee Created Successful.");
            }
            return back()->withError('something went wrong please try again later');
        }
        return abort('403');
    }
    
    public function edit(Request $request){
        if($this->user->can('Employee Edit')){
            
            $user = User::find($request->id);
            if($user){
                return view('employee.edit', compact('user'));
            }
            return redirect()->route('employee.index')->withError('User not found!');
            
        }
        return abort('403');
    }
    
    public function update(Request $request){
        if($this->user->can('Employee Edit')){
            
            $id = $request->id;
            $user = User::find($id);
            if($user){
                $request->validate([
                            'name' => 'required|string|min:2|max:50',
                            'email' => 'required|string|max:100|unique:users,email,'.$id,
                            'phone' => 'required|max:20|unique:users,phone,'.$id,
                            'gender' => 'required|max:20',
                            'civil' => 'required|max:20',
                            'birth_date' => 'required|max:20',
                            'age' => 'required|integer',
                            'national_id' => 'required|max:25|unique:users,national_id,'.$id,
                            'department' => 'required|string|max:50',
                            'position' => 'required|string|max:50',
                            'role' => 'required|string',
                            'branch' => 'required'
                        ]);
                
                $data = [
                        'branch_id' => $request->branch,
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'gender' => $request->gender,
                        'civil' => $request->civil,
                        'birth_date' => $request->birth_date,
                        'age' => $request->age,
                        'national_id' => $request->national_id,
                        'department' => $request->department,
                        'position' => $request->position,
                        'password' => bcrypt($request->password),
                    ];
                if($user){
                    $user->update($data);
                    $user->syncRoles([$request->role]);
                    return back()->withSuccess("Employee Information Updated Successful.");
                }
            }
            return redirect()->route('employee.index')->withError('Something went wrong please try again later');
            
        }
        return abort('403');
    }
    
    public function delete(Request $request){
        if($this->user->can('Employee Delete')){
            
            $id = $request->id;
            $user = User::find($id);
            if($user){
                $user->delete();
                return back()->withSuccess("Employee Account Deleted Successful.");
            }
            return redirect()->route('employee.index')->withError('User not found!');
        }
        return abort('403');
    }
    
    public function profile(Request $request){
        if($this->user->can('Profile View')){
            
            $id = $request->id??auth()->user()->id;
            $user = User::find($id);
            $collection = Attendance::where('user_id', $id)->whereMonth('created_at', date('m'))->orderBy('id', 'DESC')->get();
            
            $collection2 = Schedule::where('user_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
            $schedules = json_decode(ScheduleResource::collection($collection2)->toJson(), true);
            
            $attendances = json_decode(AttendanceResource::collection($collection)->toJson(), true);
            if($user){
                return view('employee.profile', compact('user', 'attendances', 'schedules'));
            }
            return redirect()->route('employee.index')->withError('User not found!');
        }
        return abort('403');
    }
    public function profile_update(Request $request){
        if($this->user->can('Profile Edit')){
            
            $id= auth()->user()->id;
            $request->validate([
                            'name' => 'required|string|min:2|max:50',
                            'civil' => 'required|max:20',
                            'age' => 'required|integer',
                            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
                        ]);
            
            $user = User::find($id);
            if($user){
                $data = [
                        'name' => $request->name,
                        'civil' => $request->civil,
                        'age' => $request->age,
                    ];
                if($request->hasFile('profile_image')){
                    $profile_image = $request->file('profile_image');
                    $filename = time() . '.' . $profile_image->getClientOriginalExtension();
                    $profile_image->move(public_path('/img'), $filename);
                    $data['avatar'] = $filename;
                }
                $user->update($data);
                return redirect()->route('employee.profile')->withSuccess("Profile Updated Successful.");
            }
            return redirect()->route('employee.index')->withError('Something went wrong please try again later');
        }
        return abort('403');
    }
    public function password(Request $request){
        if($this->user->can('Change Password')){
            
            $id= auth()->user()->id;
            $request->validate([
                            'old_password' => 'required|string',
                            'new_password' => 'required|string|min:6|max:50',
                            'confirm_password' => 'required_with:new_password|same:new_password|max:50',
                        ]);
                        
            $user = User::find($id);
            if($user && Hash::check($request->old_password, $user->password)) {
                $user->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                return redirect()->route('employee.profile')->withSuccess("Account Password Updated Successful.");
            }
            return redirect()->route('employee.profile')->withError("Old password not match.");
            
        }
        return abort('403');
    }
    
    
    
}
