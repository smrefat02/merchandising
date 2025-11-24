<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('buyer_id');
            $table->string('contract_no', 100)->unique();
            $table->string('season', 100);
            $table->string('revision', 50);
            $table->date('issue_date');
            $table->unsignedBigInteger('merchandiser_id');
            $table->string('shipment_terms', 150);
            $table->string('payment_terms', 150);
            $table->date('shipment_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('mode_of_shipment', ['sea', 'air', 'courier']);
            $table->boolean('allow_partial_shipment')->default(false);
            $table->boolean('allow_transshipment')->default(false);
            $table->text('bank_details')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('contract_no');
            $table->foreign('buyer_id')->references('id')->on('buyers')->cascadeOnDelete();
            $table->foreign('merchandiser_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_contracts');
    }
};
