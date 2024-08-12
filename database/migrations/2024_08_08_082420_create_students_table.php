<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('student_name');
            $table->date('student_dob');
            $table->date('student_admission_date');
            $table->date('student_dol')->nullable()->comment('Date of Leaving');
            $table->tinyInteger('student_gender');
            $table->unsignedBigInteger('student_teacher_id');
            $table->foreign('student_teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
            $table->string('student_class');
            $table->decimal('student_yearly_fees', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('students');

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['student_teacher_id']); // Drop the foreign key constraint
        });

        Schema::dropIfExists('students'); // Drop the table
    }
};
