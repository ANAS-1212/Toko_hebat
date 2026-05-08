<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register(RegisterRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,  
                'role' => $request->role ?? 'user'
            ];

            $user = $this->userRepository->create($data);
            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseHelper::success([
                'user' => $user,
                'token' => $token
            ], 'Registrasi berhasil', 201);

        } catch (\Exception $e) {
            return ResponseHelper::error('Registrasi gagal: ' . $e->getMessage(), 500);
        }
    }
    
    /*
    public function register(RegisterRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role ?? 'user'
            ];
    
            $user = $this->userRepository->create($data);
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return ResponseHelper::success([
                'user' => $user,
                'token' => $token
            ], 'Registrasi berhasil', 201);
    
        } catch (\Exception $e) {
            return ResponseHelper::error('Registrasi gagal: ' . $e->getMessage(), 500);
        }
    }
    */

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userRepository->findByEmail($request->email);
            
            if (!$user) {
                return ResponseHelper::error('Email tidak ditemukan', 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseHelper::success([
                'user' => $user,
                'token' => $token
            ], 'Login berhasil');

        } catch (\Exception $e) {
            return ResponseHelper::error('Login gagal: ' . $e->getMessage(), 500);
        }
    }
    
    /*
    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userRepository->findByEmail($request->email);
    
            if (!$user || !Auth::attempt($request->only('email', 'password'))) {
                return ResponseHelper::error('Email atau password salah', 401);
            }
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return ResponseHelper::success([
                'user' => $user,
                'token' => $token
            ], 'Login berhasil');
    
        } catch (\Exception $e) {
            return ResponseHelper::error('Login gagal: ' . $e->getMessage(), 500);
        }
    }
    */

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return ResponseHelper::success(null, 'Logout berhasil');
        } catch (\Exception $e) {
            return ResponseHelper::error('Logout gagal', 500);
        }
    }

    public function me(Request $request)
    {
        return ResponseHelper::success($request->user(), 'Data user berhasil diambil');
    }

    public function getAllUsers()
    {
        try {
            $users = $this->userRepository->getAll();
            return ResponseHelper::success($users, 'Data semua user berhasil diambil');
        } catch (\Exception $e) {
            return ResponseHelper::error('Gagal mengambil data user', 500);
        }
    }
}