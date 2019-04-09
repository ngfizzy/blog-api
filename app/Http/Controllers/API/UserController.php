<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\User;
use Auth;

class UserController extends Controller
{

  use Notifiable, HasApiTokens;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
          'firstName' => 'required|min:3|max:40',
          'lastName' => 'required|min:3|max:40',
          'email' => 'required|unique:users|email',
          'password' => 'required|min:8|max:128',
          'confirmPassword' => 'same:password'
        ]);


        $requestBody = [
          'first_name' =>  $request->get('firstName'),
          'last_name' => $request->get('lastName'),
          'email' =>  $request->get('email'),
          'password' => Hash::make($request->get('password')),
        ];

        $user = User::create($requestBody);
    
        return response()->json([
          'message' => 'signup successful',
           'user' => $user,
        ]);
    }

    public function login(Request $request) {
      $request->validate([
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if (Auth::attempt($request->only(['email', 'password']))) {
          $user = Auth::user();
          $token = $user->createToken('ngfizzy_blog', ['*'])->token;

          return response()->json([
            'success' => true,
            'message' => 'sign in successful',
            'accessToken' => $token,
          ], 200);
      }

      return response()->json([
        'success' => false,
        'message' => 'wrong username or password',
        'accessToken' => null,
      ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        response(['message' => 'welcome']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
