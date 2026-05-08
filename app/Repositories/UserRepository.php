<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
// use Illuminate\Support\Facades\Hash; 

class UserRepository implements UserInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function findById(int $id)
    {
        return User::find($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }  
    public function create(array $data)
    {
        return User::create($data);
    }
    
    /*
    
    public function create(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return User::create($data);
    }
    */

    public function update(int $id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }
    
    /*
   
    public function update(int $id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);
            return $user;
        }
        return null;
    }
    */

    public function delete(int $id)
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }
}