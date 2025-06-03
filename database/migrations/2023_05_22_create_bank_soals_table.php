<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('bank_soals', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('class'); // e.g., 'Kelas 10', 'Kelas 11', 'Kelas 12'
      $table->string('subject'); // e.g., 'Fisika', 'Kimia', etc.
      $table->text('description')->nullable();
      $table->integer('question_count')->default(0);
      $table->string('file_path');
      $table->date('upload_date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('bank_soals');
  }
};
