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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('organization_name');
            $table->string('form_name');
            $table->text('description')->nullable();
            $table->date('renewal_date');
            $table->enum('status', ['Completed', 'Overdue', 'Upcoming', 'Not Interested'])->default('Upcoming');
            $table->boolean('send_reminder')->default(true);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
