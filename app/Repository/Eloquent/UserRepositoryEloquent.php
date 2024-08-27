<?php
namespace App\Repository\Eloquent;


use App\Models\User;
use App\Repository\UserRepository;

class UserRepositoryEloquent implements UserRepository
{

    public function getByEmail(string $email): ?User
    {
        $user = User::where('email', $email)
        ->first();
        return $user;
    }
}
