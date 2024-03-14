<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyUserEmailMail;
use App\Mail\ForgotPasswordMail;
use App\Service\LogService;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            $auth_user = Auth::user();
            $tokenResult = $auth_user->createToken('auth-token')->plainTextToken;
            $token_expires_at = Carbon::now()->addWeeks(1);

            if (auth()->user()->is_deleted != 1) {
                $online = User::find(auth()->user()->id);
                $online->is_online = 1;
                $online->save();
                $logtitle = 'User Successfully logged in';
                $logdescription = 'User logged in with name ' . auth()->user()->user_firstname . ' ' . auth()->user()->user_lastname;
                LogService::userLog($logtitle, $logdescription);
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfully logged in',
                    'user_id' => auth()->user()->id,
                    'is_online' => $online->is_online,
                    'user_name' => auth()->user()->user_name,
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $token_expires_at
                    )->toDateTimeString(),
                    'ftl' => auth()->user()->user_ftl,
                    'is_verified_email' => auth()->user()->user_email_verified_at
                ]);
            } elseif (auth()->user()->is_deleted == 0) {
                $logtitle = 'Logged in but is deactivated';
                $logdescription = 'User logged in with name ' . auth()->user()->user_firstname . ' ' . auth()->user()->user_lastname;
                LogService::userLog($logtitle, $logdescription);
                return response()->json([
                    'status' => 200,
                    'message' => 'User available but is deactivated',
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $token_expires_at
                    )->toDateTimeString(),
                    'ftl' => auth()->user()->user_ftl,
                    'is_verified_email' => auth()->user()->user_email_verified_at
                ]);
            } else {
                $logtitle = 'Wrong Log in Credential';
                $logdescription = 'attempted login with email ' . $request->email;
                LogService::userLog($logtitle, $logdescription);
                return response()->json([
                    'status' => 400,
                    'message' => 'You are not registered in the app',
                ], 400);
            }
        } else {
            $logtitle = 'Wrong Log in Credential';
            $logdescription = 'attempted login with email ' . $request->email;
            LogService::userLog($logtitle, $logdescription);
            return response()->json([
                'status' => 400,
                'message' => 'Unauthenticated Login'
            ], 400);
        }
    }

    public function registerEmailChecker(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
        ]);

        $email_checker = User::where('email', $validatedData['email'])->first();

        if ($email_checker) {
            return response()->json([
                'status' => 200,
                'message' => 'Email Already Taken'
            ], 200);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Email not yet taken'
        ], 200);
    }
}
