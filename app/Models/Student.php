<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = "student_id";
    protected $table = "students";

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'student_teacher_id', 'teacher_id');
    }
}
