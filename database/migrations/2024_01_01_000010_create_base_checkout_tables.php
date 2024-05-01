<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Payavel\Orchestration\Support\ServiceConfig;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usingDatabaseDriver = ServiceConfig::get('checkout', 'defaults.driver') === 'database';

        Schema::create('payment_types', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('wallets', function (Blueprint $table) use ($usingDatabaseDriver) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('billable_id')->nullable();
            $table->string('billable_type')->nullable();
            $table->string('provider_id');
            $table->string('account_id');
            $table->string('token');
            $table->timestamps();

            if ($usingDatabaseDriver) {
                $table->foreign('provider_id')->references('id')->on('providers')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            }
        });

        Schema::create('payment_instruments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wallet_id');
            $table->string('token');
            $table->unsignedSmallInteger('type_id');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('payment_types');
        });

        Schema::create('payment_transactions', function (Blueprint $table) use ($usingDatabaseDriver) {
            $table->bigIncrements('id');
            $table->string('provider_id');
            $table->string('account_id');
            $table->string('reference');
            $table->unsignedInteger('amount');
            $table->char('currency', 3)->default('USD');
            $table->unsignedBigInteger('payment_instrument_id')->nullable();
            $table->unsignedSmallInteger('status_code');
            $table->json('details')->nullable();
            $table->timestamps();

            if ($usingDatabaseDriver) {
                $table->foreign('provider_id')->references('id')->on('providers')->onUpdate('cascade');
                $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade');
            }

            $table->foreign('payment_instrument_id')->references('id')->on('payment_instruments')->onDelete('set null');
        });

        Schema::create('payment_transaction_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('reference')->nullable();
            $table->unsignedBigInteger('amount');
            $table->smallInteger('status_code');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('payment_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transaction_events');
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payment_instruments');
        Schema::dropIfExists('payment_types');
        Schema::dropIfExists('wallets');
    }
};
