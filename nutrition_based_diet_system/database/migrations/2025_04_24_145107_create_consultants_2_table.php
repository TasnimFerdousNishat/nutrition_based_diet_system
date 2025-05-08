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
    Schema::create('consultants_2', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->string('name');
        $table->string('nid');
        $table->string('address');
        $table->string('contact')->nullable();
        $table->string('em_contact')->nullable();
        $table->date('birthday');
        $table->enum('gender', ['male', 'female', 'other']);
        $table->string('license_photo');
        $table->string('cv');
        $table->text('description')->nullable();
        $table->boolean('approved')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants_2');
    }
};
