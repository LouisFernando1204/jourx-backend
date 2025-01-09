<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationSuccessful;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:8',
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female,other',
            ]);
            $user = User::create([
                ...$validated,
                'password' => Hash::make($validated['password'])
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            try {
                Mail::to($validated['email'])->send(new RegistrationSuccessful($validated['name']));
            } catch (Exception $mailException) {
                Log::error('Mail sending failed: ' . $mailException->getMessage());
            }
            return $this->success([
                'user' => $user,
                'token' => $token,
            ], 'Registration Successful!', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 'Validation Failed!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return $this->error(null, 'Registration Failed!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $user = User::where('email', $validated['email'])->first();
            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return $this->error(null, 'Invalid Credentials!', Response::HTTP_UNAUTHORIZED);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->success([
                'user' => $user,
                'token' => $token
            ], 'Login Successful!');
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 'Validation Failed!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return $this->error(null, 'Login Failed!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register_with_google(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'uid' => 'required|string',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female,other',
            ]);
            $user = User::create([
                'uid' => $validated['uid'],
                'name' => $validated['name'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            try {
                Mail::to($validated['email'])->send(new RegistrationSuccessful($validated['name']));
            } catch (Exception $mailException) {
                Log::error('Mail sending failed: ' . $mailException->getMessage());
            }
            return $this->success([
                'user' => $user,
                'token' => $token,
            ], 'Registration with Google Successful!', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 'Validation Failed!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return $this->error(null, 'Registration with Google Failed!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login_with_google(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'uid' => 'required|string',
            ]);
            $user = User::where('uid', $validated['uid'])->first();
            if (!$user) {
                return $this->error(null, 'Invalid UID!', Response::HTTP_UNAUTHORIZED);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->success([
                'user' => $user,
                'token' => $token
            ], 'Login with Google Successful!');
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 'Validation Failed!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return $this->error(null, 'Login with Google Failed!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function check_user(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email'
            ]);
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                return $this->error(null, 'User not Found!', Response::HTTP_UNAUTHORIZED);
            }
            return $this->success([
                'user' => $user
            ], 'Email is Found!');
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 'Validation Failed!', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            Log::error('Check user error: ' . $e->getMessage());
            return $this->error(null, 'Check User Failed!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->success(null, 'Logout Successful!');
        } catch (Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return $this->error(null, 'Logout Failed!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            return $this->success($request->user(), 'User Retrieved Successfully!');
        } catch (Exception $e) {
            Log::error('Get user error: ' . $e->getMessage());
            return $this->error(null, 'Failed to Get User!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function success($data, string $message, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    private function error($errors, string $message, int $code): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
