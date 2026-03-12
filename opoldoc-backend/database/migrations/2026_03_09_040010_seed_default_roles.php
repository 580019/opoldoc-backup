<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $count = DB::table('roles')->count();
        if ($count > 0) {
            return;
        }

        DB::table('roles')->insert([
            ['role_name' => 'Admin'],
            ['role_name' => 'Doctor'],
            ['role_name' => 'Patient'],
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->whereIn('role_name', ['Admin', 'Doctor', 'Patient'])->delete();
    }
};
