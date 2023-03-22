<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Checkout;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'users', 'userToAdmin', 'forgotPassword', 'adminToUser']]);
    }

    public function forgotPassword(Request $request, $email)
    {
      $request->validate([
        'email' => 'required',
        'newPassword' => 'required',
      ]);

      $credentials = User::where('email', $email)->exists();

      if(!$credentials) {
        return response()->json([
          'message' => 'Email not found',
          'status' => 400
        ]);
      }

      $user = User::where('email', $email)->first();
      $user->password = Hash::make($request->newPassword);
      $user->save();
      
      return response()->json([
        'message' => 'Change password successfully',
        'status' => 200,
        'data' => $user,
      ]);
    }

    public function users()
    {
      $users = User::where('level', 'user')->get();

      if (!$users) {
        return response()->json([
          'message' => 'Failed',
          'status' => 400,
        ]);
      }
      
      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $users,
      ]);
    }

    public function userToAdmin($id)
    {
      $user = User::find($id);
      if (!$user) {
        return response()->json([
          'message' => 'User not found or not created',
          'status' => 400,
        ]);
      }

      $user->update(['level' => 'admin']);
      return response()->json([
        'message' => 'Update to Admin Successfully',
        'status' => 200
      ]);
    }

    // TODO: cek api ini
    public function adminToUser($id)
    {
      $user = User::find($id);
      if (!$user) {
        return response()->json([
          'message' => 'User not found or not created',
          'status' => 400,
        ]);
      }

      $user->update(['level' => 'user']);
      return response()->json([
        'message' => 'Update to Admin Successfully',
        'status' => 200
      ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'fullname' => 'required',
            'password' => 'required',
            'address' => 'required|max:255',
            'gender' => 'required',
            'telephone' => 'required',
        ]);

        $user = User::create([
            'email' => $request->email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'fullname' => $request->fullname,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'level' => 'user',
            'gender' => $request->gender,
            'telephone' => $request->telephone,
        ]);

        if ($user) {
          return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            ],
            200);
        } else {
          return response()->json([
            'status' => 'failed',
            'message' => 'Cannot created data'
          ], 400);
        }
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}