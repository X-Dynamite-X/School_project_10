<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('subjects')->insert([
            [
                'name' => 'Math',
                'subject_code' => 'MATH101',
                'success_mark' => '50',
                'full_mark' => '100',

            ], [
                'name' => 'English',
                'subject_code' => 'ENG201',
                'success_mark' => '50',
                'full_mark' => '100',
            ], [
                'name' => 'Arabic',
                'subject_code' => 'Ar101',
                'success_mark' => '50',
                'full_mark' => '100',
            ], [
                'name' => 'Computer Sciences',
                'subject_code' => 'cs101',
                'success_mark' => '50',
                'full_mark' => '100',
            ], [
                'name' => 'Sciences',
                'subject_code' => 'sci201',
                'success_mark' => '50',
                'full_mark' => '100',
            ],
        ]);
    }
}
