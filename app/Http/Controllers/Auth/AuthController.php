<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\CustomerProfile;
use App\Models\User;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Throwable;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class AuthController extends Controller
{
    //
    use Helpers;

    public function index()
    {
        return view('auth.login');
    }

    public function signUp()
    {
        return view('auth.register');
    }

    /**
     * User Registration
     *
     * User Registration - email and password
     */
    public function register(RegisterRequest $request)
    {

        try {

            DB::beginTransaction();

            // check wether user already registered

            $checkUser = User::where('email', $request->email)->first();

            if (!is_null($checkUser)) {
                return response()->json([
                    'status' => 'email_in_use',
                ], 401);
            } else {
                // creating user

                $userCreate = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'is_active' => 1,
                ]);

                // Adding permissions via a role
                $userCreate->assignRole('admin');
            }

            DB::commit();

            if (Auth::loginUsingId($userCreate->id)) {

                $tokenData = auth()->user()->createToken('UserManager', ['admin']);

                return response()->json([
                    'status' => 'success',
                    'auth_data' => [
                        'access_token' => $tokenData->accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenData->token->expires_at
                        )->toDateTimeString()
                    ],
                    'user_data' => auth()->user(),
                ], 200);
            } else {
                return response()->json([
                    'status' => 'unauthorised',
                ], 401);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return response()->json(['status' => 'Something went wrong',], 500);
        }
    }

    /**
     * Login user
     *
     * User login - email or unique id and system password
     */
    public function login(LoginRequest $request)
    {

        try {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {

                //revoke old tokens - admin
                $userTokens = auth()->user()->tokens;

                foreach ($userTokens as $token) {
                    $token->revoke();
                }

                $tokenData = auth()->user()->createToken('UserManager');

                // $session = $request->session()->put()

                return response()->json([
                    'status' => 'success',
                    'auth_data' => [
                        'access_token' => $tokenData->accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenData->token->expires_at
                        )->toDateTimeString()
                    ],
                    'user_data' => auth()->user(),
                ], 200);
            } else {

                $findUser = User::where('email', $request->email)
                    ->first();

                if (is_null($findUser)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User not found!',
                    ], 500);
                } elseif (!is_null($findUser) && $findUser->is_active == 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Inactive User!',
                    ], 500);
                } else
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unauthorised!',
                    ], 500);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return response()->json(['status' => 'Something went wrong',], 500);
        }
    }

    // public function loginApi(Request $request)
    // {
    //     $http = new \GuzzleHttp\Client;

    //     $email = $request->email;
    //     $password = $request->password;

    //     $response = $http->post('http://127.0.0.1:8000/api/login?', [
    //         'headers' => [
    //             'Authorization' => 'Bearer' . session()->get('token.access_token')
    //         ],
    //         'query' => [
    //             'email' => $email,
    //             'password' => $password,
    //         ]

    //     ]);

    //     $result = json_decode((string)$response->getBody(), true);

    //     return dd($result);

    //     return view('home');
    // }


    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {

        Auth::logout();
        return response()->json([
            'status' => 'success',
        ], 200);
    }
}
