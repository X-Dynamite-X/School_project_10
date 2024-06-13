<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $isActev = Permission::create(['name' => 'isActev']);
        $notActev = Permission::create(['name' => 'notActev']);
        $adminUser = User::where('email', 'dynamite@gmail.com')->first();
        if ($adminUser) {
            $adminUser->givePermissionTo($isActev);
        }
        $userUser = User::where('email', 'madara@gmail.com')->first();
        if ($userUser) {
            $userUser->givePermissionTo($isActev);
        }
        $userUser = User::where('email', 'mozan@gmail.com')->first();
        if ($userUser) {
            $userUser->givePermissionTo($notActev);
        }
        for ($i = 3; $i <= 100; $i++) {
            $userName = 'mozan' . $i;
            $user = User::where('name', $userName)->first();
            if ($user) {
                $user->givePermissionTo($notActev);
            }
        }
    }
}
