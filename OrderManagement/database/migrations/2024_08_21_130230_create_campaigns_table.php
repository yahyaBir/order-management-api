<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Kampanya adı
            $table->enum('type', ['discount', 'buy_one_get_one']); // Kampanya türü
            $table->decimal('value', 8, 2)->nullable(); // İndirim yüzdesi veya miktarı
            $table->decimal('discount_threshold', 8, 2)->nullable(); // İndirim için minimum alışveriş tutarı
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Kampanyanın geçerli olduğu kategori
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
