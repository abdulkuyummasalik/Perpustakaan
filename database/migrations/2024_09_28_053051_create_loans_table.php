<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('borrowed_at')->nullable(); // peminjaman
            $table->timestamp('returned_at')->nullable(); // pengembalian
            $table->timestamp('due_date')->nullable(); // batas peminjaman
            $table->integer('fine')->default(0); // denda
            $table->integer('final_fine')->nullable(); // untuk denda akhir yang disimpan
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
