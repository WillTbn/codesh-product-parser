<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');
        DB::table('users')->insert([
            'name' => 'Administrador Master',
            'email' => $email,
            'password' => bcrypt($password)
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $email = env('ADMIN_EMAIL');
        DB::delete('DELETE FROM users WHERE email=?', $email);
    }
};
