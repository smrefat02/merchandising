<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_contract_id');
            $table->text('term_text');
            $table->unsignedInteger('term_order')->default(1);
            $table->timestamps();

            $table->foreign('sales_contract_id')
                ->references('id')
                ->on('sales_contracts')
                ->cascadeOnDelete();

            $table->index('sales_contract_id');
            $table->index('term_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_terms');
    }
};
