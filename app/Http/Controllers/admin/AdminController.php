<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')->where('type','!=','superadmin')->get();
        return view('admin.admins.index', compact('admins'));
    }
    public function create()
    {
        $roles = Role::orderBy('role','asc')->get();
        return view('admin.admins.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $admin = Admin::where('email',$data['email'])->first();
        if($admin){
            return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'This email is already exists!']);
        }
        $data['password'] = Hash::make($data['password']);
        Admin::create($data);
        return redirect('admin/admin/admins')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    public function edit(Admin $admin)
    {
        $roles = Role::orderBy('role','asc')->get();
        return view('admin.admins.edit', compact('admin','roles'));
    }

    public function update(Request $request,Admin $admin)
    {
        $data = $request->all();
        if($data['password']){
            $data['password'] = Hash::make($data['password']);   
        }else{
            unset($data['password']);
        }
        $admin->update($data);
        return redirect('admin/admin/admins')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }
    
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }

    public function updateAdminDetails(Request $request, $id=null)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            if(isset($data['image'])){
                $image = 'admin-'. time().'.'.$data['image']->getClientOriginalExtension();
                $data['image']->move(public_path('uploads/admin'), $image);
                $data['image'] = $image;
                if(Auth::guard('admin')->user()->image){
                    unlink(public_path('uploads/admin/').Auth::guard('admin')->user()->image);
                }
            }
            Admin::find($id)->update($data);
            return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
        }
        return view('admin.settings.update-details');
    }
    public function updateAdminPassword(Request $request, $id=null)
    {
        if($request->isMethod('post'))
        {
            return $bool = Admin::find($id)->update(['password'=>Hash::make($request->new_password)]);
        }
        return view('admin.settings.update-password');
    }

    public function checkAdminPassword(Request $request)
    {
        if(Hash::check($request->current_password, Auth::guard('admin')->user()->password)){
            return true;
        }else{
            return false;
        }
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMsg = [
                'email.email' => 'Please enter a valid email',
                'email.required' => 'Email is required',
                'password' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMsg);

            $data = $request->all();
            if(Auth::guard('admin')->attempt(['email'=> $data['email'],'password'=> $data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Invalid Credentials!']);
            }
        }
        return view('admin.auth.login');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

}
