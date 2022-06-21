<?php

namespace Database\Factories;

use App\Models\PdfFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class PdfFileFactory extends Factory
{
    protected $model = PdfFile::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'file' => $this->faker->url
        ];
    }
}
