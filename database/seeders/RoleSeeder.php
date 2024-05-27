<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // تعيين أذونات لكل دور إذا لزم الأمر

        // تعيين الأدوار للمستخدمين
        $adminUser = User::where('email', 'dynamite@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }

        $userUser = User::where('email', 'madara@gmail.com')->first();
        if ($userUser) {
            $userUser->assignRole($userRole);
        }
        $userUser = User::where('email', 'mozan@gmail.com')->first();
        if ($userUser) {
            $userUser->assignRole($userRole);
        }
        for ($i = 3; $i <= 100; $i++) {
            $userName = 'mozan' . $i;
            $user = User::where('name', $userName)->first();
            if ($user) {
                $user->assignRole($userRole);
            }
        }
    }
}
