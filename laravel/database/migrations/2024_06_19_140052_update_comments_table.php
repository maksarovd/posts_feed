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
        Schema::table('comments', function (Blueprint $table) {
            $table->fullText('text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropFullText('text');
        });
    }
};
