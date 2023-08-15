<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\AgreementType;
// use App\Models\User;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;

// class LoginController extends Controller
// {
//   use AuthenticatesUsers;

//   /**
//    * @var string
//    */
//   protected $redirectTo = RouteServiceProvider::TOP;

//   public function login(Request $request)
//   {
//     try {
//       $request->validate([
//         'email' => 'email|required',
//         'password' => 'required'
//       ]);

//       $credentials = request(['email', 'password']);

//       if (!Auth::attempt($credentials)) {
//         return response()->json([
//           'status_code' => 500,
//           'message' => 'Unauthorized'
//         ]);
//       }

//       $user = User::where('email', $request->email)->first();

//       if (!Hash::check($request->password, $user->password, [])) {
//         throw new \Exception('Error in Login');
//       }

//       $tokenResult = $user->createToken('authToken')->plainTextToken;

//       return response()->json([
//         'status_code' => 200,
//         'access_token' => $tokenResult,
//         'token_type' => 'Bearer',
//       ]);
//     } catch (\Exception $error) {
//       return response()->json([
//         'status_code' => 500,
//         'message' => 'Error in Login',
//         'error' => $error,
//       ]);
//     }
//   }
// }
