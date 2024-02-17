<?php

use App\Models\Role;
use App\Models\Store;
use App\Models\StoreUser;
use App\Models\User;
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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('store_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('locale');
            $table->foreignIdFor(Store::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('store_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Store::class)->constrained()->cascadeOnDelete();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_user');
        Schema::dropIfExists('store_translations');
        Schema::dropIfExists('stores');
    }
};