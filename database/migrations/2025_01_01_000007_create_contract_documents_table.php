<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_contract_id');
            $table->string('document_name', 255);
            $table->boolean('is_required')->default(true);
            $table->unsignedInteger('deadline_days')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();

            $table->foreign('sales_contract_id')
                ->references('id')
                ->on('sales_contracts')
                ->cascadeOnDelete();

            $table->index('sales_contract_id');
            $table->index('document_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_documents');
    }
};
