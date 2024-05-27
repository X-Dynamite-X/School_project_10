<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        DB::table('subject_users')->insert([
            [
                'user_id' => '1',
                'subject_id' => '1',
                'mark' => '50',

            ], [
                'user_id' => '1',
                'subject_id' => '2',
                'mark' => '70',
            ], [
                'user_id' => '1',
                'subject_id' => '3',
                'mark' => '40',
            ], [
                'user_id' => '1',
                'subject_id' => '4',
                'mark' => '68',
            ], [
                'user_id' => '1',
                'subject_id' => '5',
                'mark' => '66',
            ],
            [
                'user_id' => '2',
                'subject_id' => '1',
                'mark' => '75',

            ], [
                'user_id' => '2',
                'subject_id' => '2',
                'mark' => '70',
            ], [
                'user_id' => '2',
                'subject_id' => '3',
                'mark' => '90',
            ], [
                'user_id' => '3',
                'subject_id' => '4',
                'mark' => '68',
            ],
        ]);
    }
}
