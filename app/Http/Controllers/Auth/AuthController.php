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

            $hasAlreadyUser = false;

            // check wether user already registered

            $checkUser = User::where('email', $request->email)->first();


            if (!is_null($checkUser)) {
                $hasAlreadyUser = true;
                return redirect()->back()->withInput()->with('error', 'Email already in use');
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

                return redirect('/dashboard')->with('success', 'Register & Login success!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Unauthorised!');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;

            return response()->json(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Login user
     *
     * User login - email or unique id and system password
     */
    public function login(LoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;

        $findUserWithCredentials = User::where('email', $email)
            ->where('is_active', 1)
            ->first();

        // if (Auth::login($findUserWithCredentials->id)) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {

            //revoke old tokens - admin
            $userTokens = auth()->user()->tokens;

            foreach ($userTokens as $token) {
                $token->revoke();
            }

            $tokenData = auth()->user()->createToken('UserManager', ['admin']);

            return redirect('/dashboard')->with('success', 'Login success!');
        } else {

            $findUser = User::where('email', $request->email)
                ->first();

            if (is_null($findUser)) {
                return redirect()->back()->withInput()->with('error', 'User not found!');
            } elseif (!is_null($findUser) && $findUser->is_active == 0) {
                return redirect()->back()->withInput()->with('error', 'Inactive User!');
            }
            return redirect()->back()->withInput()->with('error', 'Unauthorised!');
        }
    }


    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {

        Auth::logout();
        return redirect('/')->with('success', 'Logout success!');
    }
}
