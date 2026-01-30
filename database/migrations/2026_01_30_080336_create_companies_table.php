<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');

            $table->string('username')->unique()->after('email');
            $table->enum('type', ['Buyer', 'Exhibitor', 'Visitor'])->default('Buyer')->after('username');

            $table->dropColumn('name');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('address');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->year('year_established');
            $table->string('website')->nullable();
            $table->string('brochure_path')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('companies');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'type']);
        });
    }
};