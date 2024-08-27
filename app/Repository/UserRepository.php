<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository
{
    // public function all():int|Collection;
    public function getByEmail(string $email):?User;
}
