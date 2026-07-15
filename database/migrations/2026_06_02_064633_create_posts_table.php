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
        Schema::create('posts', function (Blueprint $table) {

            // id INT AUTO_INCREMENT PRIMARY KEY
            $table->integer('id', true);

            $table->string('title', 200);
            $table->string('slug', 255)->unique();
            $table->text('content');
            $table->string('image', 200)->nullable();

            $table->tinyInteger('status')->default(1);

            // user_id BIGINT
            $table->unsignedBigInteger('user_id');

            // khóa ngoại + không cho xóa user nếu còn bài viết
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
