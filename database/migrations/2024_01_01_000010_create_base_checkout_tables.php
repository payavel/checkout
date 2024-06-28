<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Payavel\Orchestration\ServiceConfig;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usingDatabaseDriver = ServiceConfig::find('checkout')->get('defaults.driver') === 'database';

        Schema::create('payment_types', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('logo')->default('checkoutshopper-live.adyen.com/checkoutshopper/images/logos/card.svg');
            $table->timestamps();
        });

        Schema::create('payment_rails', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('parent_type_id');
            $table->string('type_id');
            $table->timestamps();

            $table->foreign('parent_type_id')->references('id')->on('payment_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('payment_types')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('wallets', function (Blueprint $table) use ($usingDatabaseDriver) {
            $table->bigIncrements('id');
            $table->nullableMorphs('billable');
            $table->string('provider_id');
            $table->string('account_id');
            $table->string('reference');
            $table->timestamps();

            if ($usingDatabaseDriver) {
                $table->foreign('provider_id')->references('id')->on('providers')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            }

            $table->index('reference');
        });

        Schema::create('payment_instruments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wallet_id');
            $table->string('type_id');
            $table->string('reference');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('payment_types')->onUpdate('cascade');
            $table->index('reference');
        });

        Schema::create('payments', function (Blueprint $table) use ($usingDatabaseDriver) {
            $table->bigIncrements('id');
            $table->string('provider_id');
            $table->string('account_id');
            $table->string('reference');
            $table->boolean('authorized')->default(true);
            $table->unsignedInteger('amount');
            $table->char('currency', 3)->default('USD');
            $table->string('rail_id');
            $table->unsignedBigInteger('instrument_id')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();

            if ($usingDatabaseDriver) {
                $table->foreign('provider_id')->references('id')->on('providers')->onUpdate('cascade');
                $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade');
            }

            $table->index('reference');
            $table->index('authorized');
            $table->foreign('rail_id')->references('id')->on('payment_rails')->onUpdate('cascade');
            $table->foreign('instrument_id')->references('id')->on('payment_instruments')->onDelete('set null');
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_id');
            $table->string('reference');
            $table->unsignedInteger('amount');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->index('reference');
        });

        Schema::create('disputes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_id');
            $table->string('reference');
            $table->unsignedInteger('amount');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->index('reference');
        });

        Schema::create('transaction_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_id');
            $table->nullableMorphs('transactionable');
            $table->string('reference');
            $table->unsignedInteger('status_code');
            $table->unsignedInteger('amount');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->index('reference');
            $table->index('status_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_events');
        Schema::dropIfExists('disputes');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_instruments');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('payment_rails');
        Schema::dropIfExists('payment_types');
    }
};
