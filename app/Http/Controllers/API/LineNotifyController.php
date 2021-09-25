<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineNotifyService;
use App\Models\LineNotifyToken;
use App\Models\Ip;
use App\Models\User;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LineNotifyController extends Controller
{


    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        $linenotify = new LineNotifyService();

        $linenotifytoken = [
            'token' => $linenotify->get_access_tooken($request->code),
            'user_id' => Auth::user()->id
        ];

        $linenotifytoken = LineNotifyToken::create($linenotifytoken);

        $response = [
            'success' => true,
            'message' => "成功!",
        ];

        return response()->json($response);
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $token = Auth::user()->linenotifytoken;

        if ($token) {
            $success = $token->delete();
        } else {
            $success = false;
        }

        $response = [
            'success' => $success,
            'data' => Auth::user()->load('linenotifytoken')
        ];

        return response()->json($response);
    }
}
