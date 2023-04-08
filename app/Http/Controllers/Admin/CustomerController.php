<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id', 2)->get();
        return view('admin.user.index', compact('users'));
        // your code here
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // your code here
        Validator::make($request->all(), [
            'name' => ['required','string'],
            'email' => ['required','string','email','max:255','unique:users'],
            'phone' => ['required','numeric','digits:10','unique:users'],
            'dob' => ['required'],
            'password' => [new Password, 'confirmed'],
        ])->validate();
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'role_id' => 2,
            'status' => 1,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'date_of_birth' => $request->dob,
        ]);
        return redirect()->route('user.index')->with('success', 'New User added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::where('id', $id)->first();
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::where('id', $id)->first();
        return view('admin.user.edit', compact('user'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::where('id', $id)->first();
        if($user->email==$request->email && $user->phone==$request->phone){
            Validator::make($request->all(), [
                'name' => ['required','string'],
                'dob' => ['required'],
            ])->validate();
        }
        elseif($user->email==$request->email){
            Validator::make($request->all(), [
                'name' => ['required','string'],
                'phone' => ['required','numeric','digits:10','unique:users'],
                'dob' => ['required'],
            ])->validate();
            $user->phone=$request->phone;
        }
        elseif($user->phone==$request->phone){
            Validator::make($request->all(), [
                'name' => ['required','string'],
                'email' => ['required','string','email','max:255','unique:users'],
                'dob' => ['required'],
            ])->validate();
            $user->email=$request->email;
        }
        else{
            Validator::make($request->all(), [
                'name' => ['required','string'],
                'email' => ['required','string','email','max:255','unique:users'],
                'phone' => ['required','numeric','digits:10','unique:users'],
                'dob' => ['required'],
            ])->validate();
            $user->email=$request->email;
            $user->phone=$request->phone;
        }
        $user->name=$request->name;
        $user->date_of_birth=$request->dob;
        $user->save();
        return redirect()->route('user.index')->with('success', 'User Info Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success','User deleted successfully!');
    }
    public function change_status(Request $request){
        $user=User::where('id', $request->id)->first();
        if($user->status==1){
            $user->status=0;
            $user->save();
            return response()->json(['status'=>true,'message'=>'User Deactivated Successfully!']);
        }
        else{
            $user->status=1;
            $user->save();
            return response()->json(['status'=>true,'message'=>'User Activated Successfully!']);
        }
    }
}
