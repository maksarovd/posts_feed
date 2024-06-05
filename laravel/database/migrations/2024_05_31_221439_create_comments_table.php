<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @see https://dev.mysql.com/doc/refman/8.4/en/integer-types.html
     * @see https://www.ibm.com/docs/en/db2/10.5?topic=list-datetime-values
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->char('homepage',50)->nullable(true);
            $table->char('captcha', 20);
            $table->text('text');
            $table->tinyInteger('nested')->nullable();
            $table->timestamp('created_at')->default(NOW())->index();
            $table->timestamp('updated_at')->default(NOW());
            $table->foreignId('parent_id')->nullable()->references('id')->on('comments')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
