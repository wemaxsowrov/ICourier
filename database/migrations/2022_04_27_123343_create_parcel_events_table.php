<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id')->constrained('parcels')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_man')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pickup_man_id')->nullable()->constrained('delivery_man')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('transfer_delivery_man_id')->nullable()->constrained('delivery_man')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->tinyInteger('parcel_status')->nullable();
            $table->string('delivery_lat')->nullable();
            $table->string('delivery_long')->nullable();
            $table->longText('signature_image')->nullable();
            $table->longText('delivered_image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();


            $table->index('hub_id');
            $table->index('delivery_man_id');
            $table->index('pickup_man_id');
            $table->index('parcel_id');
            $table->index('parcel_status');
            $table->index('transfer_delivery_man_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_events');
    }
};
