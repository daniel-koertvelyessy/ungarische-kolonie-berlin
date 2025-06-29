<?php

declare(strict_types=1);

use App\Models\Blog\PostType;
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
        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')
                ->unique();
            $table->string('description')
                ->nullable();
            $table->string('color')
                ->nullable();
            $table->timestamps();
        });

        PostType::create([
            'name' => [
                'hu' => 'Bejelentés',
                'de' => 'Ankündigung',
            ],
            'slug' => 'announcement',
            'color' => 'yellow',
            'description' => '',
        ]);
        PostType::create([
            'name' => [
                'hu' => 'Visszatekintés',
                'de' => 'Rückblick',
            ],
            'slug' => 'review',
            'color' => 'blue',
            'description' => '',
        ]);
        PostType::create([
            'name' => [
                'hu' => 'Beszámoló',
                'de' => 'Bericht',
            ],
            'slug' => 'report',
            'color' => 'lime',
            'description' => '',
        ]);
        PostType::create([
            'name' => [
                'hu' => 'Egyéb',
                'de' => 'Anderes',
            ],
            'slug' => 'other',
            'color' => 'slate',
            'description' => '',
        ],
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_types');
    }
};
