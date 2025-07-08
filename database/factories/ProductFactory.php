<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $name = $this->faker->words(3, true);
    $slug = Str::slug($name . '-' . uniqid());

    // Use dummy image filenames
    $image = ['dummy.jpg','dummy2.jpg','dummy3.jpg'];

    // Random gallery selection from known dummy gallery images
    $galleryImages = [
        'gallery1.jpg',
        'gallery2.jpg',
        'gallery3.jpg',
    ];

    // Shuffle and pick 2-3 random images
    shuffle($galleryImages);
    $selectedGallery = array_slice($galleryImages, 0, rand(2, 3));

    return [
        'name'              => $name,
        'slug'              => $slug,
        'category_id'       => \App\Models\Category::factory(),
        'brand_id'          => \App\Models\Brand::factory(),
        'short_description' => $this->faker->sentence,
        'description'       => $this->faker->paragraph(5),
        'regular_price'     => $regular = $this->faker->randomFloat(2, 50, 500),
        'sale_price'        => $this->faker->boolean(50) ? $this->faker->randomFloat(2, 10, $regular) : null,
        'SKU'               => strtoupper($this->faker->bothify('SKU###??')),
        'quantity'          => $this->faker->numberBetween(1, 100),
        'stock_status'      => $this->faker->randomElement(['instock', 'outofstock']),
        'featured'          => $this->faker->boolean(30),
        'image'             => $this->faker->randomElement($image),
        'images'            => json_encode($selectedGallery),
    ];
}

}
