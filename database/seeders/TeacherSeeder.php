<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'teacher_name' => 'Shalu Gupta',
            'teacher_dob' => '1980-05-15',
            'teacher_doj' => '2010-09-01',
            'teacher_dol' => null, // Nullable field
            'teacher_gender' => 1
        ]);

        Teacher::create([
            'teacher_name' => 'Anjali Gupta',
            'teacher_dob' => '1985-07-22',
            'teacher_doj' => '2015-02-10',
            'teacher_dol' => '2017-02-10',
            'teacher_gender' => 1
        ]);
    }
}
