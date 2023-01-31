<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // public function __construct()
    // {
    //     $this-middleware('auth')->only([create, edit, update, destroy]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(5); //Paginate the list of users, showing 5 at a time

        return view('users.index', compact('users'))->with(request()->input('page')); //Display the page number within the URL
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email:rfc,dns'],
            'employee_id' => ['required', 'regex:[UID-\d+]'] //Checks to see that the Employee ID begins with UID- and is followed by digits
        ],
        [
            //Custom error message for Regex above
            'employee_id.regex' => 'Employee ID must begin with UID- followed by your ID numbers'
        ]);

        User::create($request->all());

        return redirect()->route('users.index')->with('success','User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email:rfc,dns'],
            'employee_id' => ['required', 'startsWith:UID-']
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
