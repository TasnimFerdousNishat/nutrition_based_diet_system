<?php

// Migration file
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('birthday');
            $table->string('gender');
            $table->string('address');
            $table->string('contact')->nullable();
            $table->string('em_contact')->nullable();
            $table->string('diabetes');
            $table->string('menstrual_cycle')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
};
