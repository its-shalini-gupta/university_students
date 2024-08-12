<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'student_name' => 'Shalini Gupta',
            'student_dob' => '2000-11-01',
            'student_admission_date' => '2024-01-10',
            'student_dol' => null,
            'student_class' => '10th',
            'student_teacher_id' => 1,
            'student_yearly_fees' => 1000.00,
            'student_gender' => 1
        ]);

        Student::create([
            'student_name' => 'Vikas Gupta',
            'student_dob' => '2011-11-02',
            'student_admission_date' => '2024-02-15',
            'student_dol' => '2024-08-15',
            'student_class' => '9th',
            'student_teacher_id' => 2,
            'student_yearly_fees' => 1200.00,
            'student_gender' => 0
        ]);
    }
}
