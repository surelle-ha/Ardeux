<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('EmployeeNum')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('Role');
            $table->string('Wallet');
            $table->string('IsActive');
            $table->string('requireNewPassword');
            $table->rememberToken();
            $table->timestamps();
        });
        \App\Models\User::create([
            'id' => 'ARD10000',
            'FirstName' => 'Harold',
            'LastName' => 'Eustaquio',
            'EmployeeNum' => 'ARD10000',
            'email' => '0110harold@gmail.com',
            'password' => bcrypt('Izukishun@30'),
            'Role' => 'SuperUser',
            'Wallet' => '7r987oKHBag9fhjqdGKcritP43xLW5qLFZJDgYsFiVzV',
            'IsActive' => '1',
            'requireNewPassword' => '1',
            'remember_token' => Str::random(10),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
