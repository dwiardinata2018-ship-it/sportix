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
        Schema::table('payment_records', function (Blueprint $table) {
            $table->string('midtrans_order_id', 100)
                ->nullable()
                ->unique();

            $table->string('midtrans_transaction_id', 100)
                ->nullable()
                ->index();

            $table->text('midtrans_qr_url')->nullable();

            $table->dateTime('midtrans_expired_at')->nullable();

            $table->string('midtrans_transaction_status', 50)
                ->nullable();
        });

        DB::statement("
            ALTER TABLE payment_records
            MODIFY payment_method
            ENUM('transfer', 'cash', 'qris')
            NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE payment_records
            MODIFY payment_method
            ENUM('transfer', 'cash')
            NOT NULL
        ");

        Schema::table('payment_records', function (Blueprint $table) {
            $table->dropUnique(['midtrans_order_id']);
            $table->dropIndex(['midtrans_transaction_id']);

            $table->dropColumn([
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_qr_url',
                'midtrans_expired_at',
                'midtrans_transaction_status',
            ]);
        });
    }
};
