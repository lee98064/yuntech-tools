<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ip;
use App\Services\IpFlowService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OverFlowNotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ip = $request->ip ? $request->ip : request()->ip();

        $ipflow = new IpFlowService();

        $flower = $ipflow->GetFlow($ip);
        $flower = $ipflow->humanFileSize($flower);
        $ips = IP::where('user_id', Auth::user()->id)->orderByDesc('id')->get();

        $response = [
            'success' => true,
            'ip' => $ip,
            'ips' => $ips,
            'flower' => $flower
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

        $ip = [
            'ip' => $request->ip,
            'linenotify' => $request->linenotify,
            'webnotify' => $request->webnotify,
            'user_id' => Auth::user()->id,
        ];

        $ip = IP::create($ip);

        $ips = IP::where('user_id', Auth::user()->id)->orderByDesc('id')->get();

        $response = [
            'success' => true,
            'ips' => $ips
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
        $ip = auth()->user()->ips->find($id);
        $success = false;

        $success = $ip->delete();
        $ips = IP::where('user_id', Auth::user()->id)->orderByDesc('id')->get();

        $response = [
            'success' => $success,
            'ips' => $ips
        ];

        return response()->json($response);
    }
}
