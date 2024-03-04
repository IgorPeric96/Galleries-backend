<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Image::class;
    public function definition(): array
    {
        return [
            'image_url' => $this->faker->imageUrl(640, 480, 'flowers'),
            'gallery_id' => Gallery::factory(),
        ];
    }
}
