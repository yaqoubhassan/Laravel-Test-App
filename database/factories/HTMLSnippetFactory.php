<?php

namespace Database\Factories;

use App\Models\HTMLSnippet;
use Illuminate\Database\Eloquent\Factories\Factory;

class HTMLSnippetFactory extends Factory
{
    protected $model = HTMLSnippet::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'snippet' => $this->faker->text
        ];
    }
}
