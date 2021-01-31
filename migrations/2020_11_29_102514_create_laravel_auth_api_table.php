<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaravelAuthApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'email')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email')->unique()->nullable();
            });
        }
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->after('email')->unique()->nullable();
            });
        }
        if (!Schema::hasColumn('users', 'api_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('api_token', 80)->after('password')
                    ->unique()
                    ->nullable()
                    ->default(null);
            });
        }

        Schema::create('auth_api_email_code', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('code');
            $table->string('pass');
            $table->integer('use')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_api_email_code');
    }
}
