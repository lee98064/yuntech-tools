<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Register
     */
    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->nickname = $request->nickname;
            $user->stu_id = $request->stu_id;
            $user->sex = $request->sex;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'User register successfully';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = 'User register failed';
            // $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $success = true;
            $message = 'User login successfully';
        } else {
            $success = false;
            $message = 'Unauthorised';
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    /**
     * Logout
     */
    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }


    public function getuser()
    {
        $response = [
            'success' => true,
            'data' => Auth::user()->load('linenotifytoken'),
        ];
        return response()->json($response);
    }

    public function update(Request $request)
    {

        try {
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->nickname = $request->nickname;
            $user->stu_id = $request->stu_id;
            $user->sex = $request->sex;
            $user->email = $request->email;
            $user->save();

            $success = true;
            $message = 'User update successfully';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = 'User update failed';
            // $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return response()->json($response);
    }

    public function updatepd(Request $request)
    {

        $user = User::find(Auth::id());

        $message = 'Unauthorised';
        if (Hash::check($request->oldpd, $user->password)) {
            $success = true;
            $user->password = Hash::make($request->newpd);
            if ($user->save()) {
                $message = 'User password update successfully';
            } else {
                $message = 'Failed';
            }
        } else {
            $success = false;
            $message = 'Failed';
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return response()->json($response);
    }
}
