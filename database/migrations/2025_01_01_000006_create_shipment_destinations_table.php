<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipment_destinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_contract_id');
            $table->string('destination_code', 50);
            $table->string('country', 100);
            $table->string('port', 150);
            $table->string('final_destination', 255);
            $table->unsignedInteger('units')->default(0);
            $table->unsignedInteger('packs')->default(0);
            $table->string('vat_no', 50)->nullable();
            $table->timestamps();

            $table->index('destination_code');
            $table->index('sales_contract_id');
            $table->index('country');
            $table->foreign('sales_contract_id')->references('id')->on('sales_contracts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_destinations');
    }
};
