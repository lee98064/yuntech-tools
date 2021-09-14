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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $linenotify = new LineNotifyService();

        $linenotifytoken = [
            'type' => $request->state,
            'token' => $linenotify->get_access_tooken($request->code),
            'user_id' => Auth::user()->id
        ];

        $linenotifytoken = LineNotifyToken::create($linenotifytoken);

        $ip = [
            'ip' => Session::pull('ip', '127.0.0.1'),
            'user_id' => Auth::user()->id,
            'linenotifytoken_id' => $linenotifytoken->id
        ];

        $ip = IP::create($ip);

        $response = [
            'success' => true,
            'message' => "成功!",
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
