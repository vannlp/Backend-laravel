<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function getSession(Request $request) {
        $input = $request->all();

        if(!empty($input['session_id'])) {
            $session_id = $input['session_id'];
            $session = Session::where('session_id', $session_id)->first();

            if(!$session) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Session_id không tồn tại'
                ], 400);
            }

            return response()->json([
                'status' => 'susses',
                'data' => [
                    'id' => $session->id,
                    'session_id' => $session->session_id,
                    'ip' => $session->ip,
                ]
            ]);
        }

        $create_session_param = [
            'session_id' => Str::random(20),
            'ip'    => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        $session = Session::create($create_session_param);
        return response() -> json([
            'status' => 'success',
            'data' => [
                'id' => $session->id,
                'session_id' => $session->session_id,
                'ip' => $session->ip,
            ],
        ]);
    }
}
