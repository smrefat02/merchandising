<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pack_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_contract_id');
            $table->string('pack_id', 50);
            $table->string('gtin', 20)->nullable();
            $table->string('pack_type', 100);
            $table->string('color', 50);
            $table->string('ratio', 255);
            $table->unsignedInteger('total_units')->default(0);
            $table->timestamps();

            $table->index('pack_id');
            $table->index('sales_contract_id');
            $table->foreign('sales_contract_id')->references('id')->on('sales_contracts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pack_configurations');
    }
};
