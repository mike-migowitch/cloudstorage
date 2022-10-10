<?php

use App\Models\User;
use App\Models\Directory;
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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Directory::class)->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('filename');
            $table->integer('public_uid')->nullable();
            $table->unique('public_uid');
            $table->integer('disk_space');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(User::class);
            $table->dropConstrainedForeignIdFor(Directory::class);
        });
        Schema::dropIfExists('files');
    }
};
