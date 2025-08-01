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
//         قاعدة عامة:
// في العلاقة بين جدولين أو بين صفوف في نفس الجدول:
// الأب هو الكيان الرئيسي اللي الآخر يعتمد عليه.
// الابن هو الكيان اللي بيحتوي على مفتاح أجنبي يشير للأب
// أنت عامل علاقة داخلية في نفس الجدول 
// (Self Relationship) — يعني:
// ممكن يكون له أب  فئة أخرىcategoriesكل صف في جدول  
//هو اللي بيوضح مين الاب parent_id
            
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories','id')
                ->nullOnDelete();
            $table->string('name');  
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['active','archived']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
