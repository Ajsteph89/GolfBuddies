<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('id');
            $table->string('zipcode', 10)->nullable()->after('username');
            $table->text('profile')->nullable()->after('zipcode');
            $table->float('handicap')->nullable()->after('profile');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'zipcode', 'profile', 'handicap']);
        });
    }    
};
