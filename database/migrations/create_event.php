<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('city');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('category_id')->contrained()->onDelete('cascade');
            $table->string('event_poster')->nullable();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->integer('ticket_capacity');
            $table->string('important_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
