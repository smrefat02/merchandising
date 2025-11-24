<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliance_clauses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_contract_id');
            $table->string('clause_code', 10);
            $table->string('description', 500);
            $table->decimal('penalty_usd', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('sales_contract_id')
                ->references('id')
                ->on('sales_contracts')
                ->cascadeOnDelete();

            $table->index('sales_contract_id');
            $table->index('clause_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_clauses');
    }
};
