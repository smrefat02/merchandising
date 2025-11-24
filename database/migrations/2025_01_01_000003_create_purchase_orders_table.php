<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_contract_id');
            $table->string('po_no', 100)->unique();
            $table->string('buyer_ref', 100)->nullable();
            $table->string('dept', 100);
            $table->string('class', 100);
            $table->string('subclass', 100)->nullable();
            $table->string('season', 50);
            $table->date('handover_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedInteger('total_qty')->default(0);
            $table->decimal('value_usd', 15, 2)->default(0.00);
            $table->timestamps();

            $table->index('po_no');
            $table->index('sales_contract_id');
            $table->index('season');
            $table->foreign('sales_contract_id')->references('id')->on('sales_contracts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
