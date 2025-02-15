<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();
            $table->string('client_name', 255);
            $table->char('client_doctype', 3);
            $table->string('client_doc', 20);
            $table->string('client_email')->unique()->nullable();
            $table->unsignedBigInteger('seller_id');
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
