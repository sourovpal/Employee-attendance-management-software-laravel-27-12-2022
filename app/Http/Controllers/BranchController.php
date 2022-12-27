<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    private $user;
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->user = auth()->user();
            return $next($request);
        });
    }
    
    public function index(){
        if($this->user->can('Branch View')){
            $branchs = Branch::get();
            return view('branch.index',compact('branchs'));
        }
        return abort('403');
    }
    
    public function create(){
        if($this->user->can('Branch Create')){
            return view("branch.create");
        }
        return abort('403');
    }
    
    public function store(Request $request){
        if($this->user->can('Branch Create')){
            
            $request->validate([
                "name" => "required|string"
            ]);
            $data = [
                'name' => $request->name
            ];
            
            $branch = Branch::create($data);
            if($branch){
                return back()->withSuccess("New Branch Created Successful.");
            }
        }
        return abort('403');
    }
    
    
    public function edit($id){
        if($this->user->can('Branch Edit')){
            
            $branch = Branch::findOrFail($id);
            return view("branch.edit",compact('branch'));
            
        }
        return abort('403');
    }
    
    public function update(Request $request){
        if($this->user->can('Branch Edit')){
            $id = $request->id;
            $branch = Branch::find($id);
            
            $data = [
                'name' => $request->name
            ];
            $branch->update($data);
            return back()->withSuccess("Branch Updated Successful.");
        }
        return abort('403');
    }
    
    public function delete(Request $request){
        if($this->user->can('Branch Delete')){
            
            $id = $request->id;
            $branch = Branch::find($id);
            if($branch){
                $branch->delete();
                return back()->withSuccess("Branch Deleted Successful.");
            }
            return redirect()->route('branch.index')->withError('User not found!');
        }
        return abort('403');
    }
}
