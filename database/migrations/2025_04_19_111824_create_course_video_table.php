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
        Schema::create('course_videos', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('title');              // Changed from video_name
            $table->string('video_url');
            $table->integer('duration');          // Changed from video_duration
            $table->integer('order')->default(1); // Changed from video_order
            $table->timestamps();

            //hapus otomatis video jika course dihapus
            $table->foreign('course_code')
                ->references('course_code')
                ->on('e_course')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_videos');
    }
};
