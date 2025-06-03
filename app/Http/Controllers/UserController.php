<?php

namespace App\Http\Controllers;

use App\Http\Id\UserId;
use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Http\Trait\RoleTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Exception\UserException;
use App\Service\OTPValidation;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    use RoleTrait;

    protected OTPValidation $otpValidator;

    public function __construct(OTPValidation $otpValidator)
    {
        $this->otpValidator = $otpValidator;
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            $post = $request->all();
            $user = User::createUser($post);
            $user->save();
            return ApiResponse::success('User created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error creating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function getUser(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('user');
        return new JsonResponse(array_merge($user->data(), [
            "roleName" => $this->getRoleName($user->roleId())
        ]));
    }

    public function getUsers(Request $request): JsonResponse
    {
        $query = $request->query();
        $data = [];
        $limit = isset($query['limit']) ? intval($query['limit']) : 20;
        $skip = isset($query['skip']) ? intval($query['skip']) : 0;
        $allowed = ['lastName', 'firstName', 'email'];
        $requested = array_keys($query);
        $filters = array_intersect($allowed, $requested);

        /**@var User */
        $users = User::query();
        foreach ($filters as $filter) {
            $users->where($filter, $query[$filter]);
        }

        $users = $users->skip($skip)->take($limit)->get();
        foreach ($users as $user) {
            $data[] = array_merge($user->data(), [
                "roleName" => $this->getRoleName($user?->roleId())
            ]);
        }
        return new JsonResponse(
            [
                'totalRecords' => count($data),
                'data' => $data
            ]
        );
    }

    public function updateUserDetails(Request $request): JsonResponse
    {
        try {
            $post = $request->all();
            /** @var User */
            $user = $request->attributes->get('user');
            $user->updateUser($user, $post);
            return ApiResponse::success('User updated successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error updating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function deleteUser(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $request->attributes->get('user');
            $request->delete($user);
            return ApiResponse::success('User deleted successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error deleting user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function changeUserPassword(CreateUserRequest $request): JsonResponse
    {
        try {
            /** @var User */
            $user = $request->attributes->get('user');
            $post = $request->all();
            $user->changePassword($user, $post);
            return ApiResponse::success('User updated successfully', StatusCode::OK);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error updating user', $e->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'email' => 'required|string|email'
        ]);

        $validatedData = $validator->validate();

        $user = User::where('email', $validatedData['email'])->first();

        $validatedData = $validator->validate();
        if ($validatedData['email'] !== $user->email() &&  !Hash::check($validatedData['password'], $user->password())) {
            throw UserException::InvalidLoginCredential($user);
        }
        $payload = [
            'iss' => "your-app",
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 3600
        ];
        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    //  public function login(Request $request)
    // {
    //     $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required|string'
    //     ]);

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Login successful',
    //         'token'   => $token,
    //         'user'    => $user], 401);
    //     }

    //     $user = Auth::user();

    //     if (!$user->email_verified_at) {
    //         return response()->json(['error' => 'Please verify your OTP before logging in'], 403);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'token'   => $token,
    //         'user'    => $user
    //     ]);
    // }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|string']);
        /** @var User */
        $user = auth()->guard()->user();

        try {
            $this->otpValidator->validateOtp($user, $request->input('otp'));
            $user->otp = null; // Clear OTP after success
            $user->save();

            return response()->json(['message' => 'OTP verified successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function sendOtp(Request $request)
    {
        /** @var User */
        $user = Auth::user(); // or fetch the user manually

        $user->otp = (object) [
            'value' => rand(100000, 999999),
            'createdOn' => now()->toISOString(),
            'expiresOn' => now()->addMinutes(10)->toISOString(),
        ];
        $user->save();

        // Send OTP to user via email or SMS here...

        return response()->json(['message' => 'OTP sent successfully.']);
    }
}
