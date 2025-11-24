<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->string('style_no', 100);
            $table->string('style_name', 255);
            $table->unsignedInteger('qty')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('total_value', 15, 2)->default(0.00);
            $table->timestamps();

            $table->index('style_no');
            $table->index('purchase_order_id');
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('styles');
    }
};
