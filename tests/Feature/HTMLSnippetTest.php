<?php

namespace Tests\Feature;

use App\Models\HTMLSnippet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HTMLSnippetTest extends TestCase
{
    use RefreshDatabase;
    use withFaker;

    /**
     * @test
     */
    public function test_it_lists_html_snippets()
    {
        HTMLSnippet::factory(5)->create();

        $response = $this->json('GET', route('html-snippets.index'));
        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    /**
     * @test
     */
    public function test_it_adds_html_snippet()
    {
        $input = [
            'title' => $this->faker->word(3, true),
            'description' => $this->faker->sentence,
            'snippet' => $this->faker->text
        ];

        $response = $this->json('POST', route('html-snippets.store'), $input);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => $input['title']
            ]);
    }

    /**
     * @test
     */
    public function test_it_views_html_snippet()
    {
        $htmlSnippet = HTMLSnippet::factory()->create();

        $response = $this->json('GET', route('html-snippets.show', $htmlSnippet));
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $htmlSnippet->id,
                'title' => $htmlSnippet->title,
                'description' => $htmlSnippet->description
            ]);
    }

    /**
     * @test
     */
    public function test_it_updates_html_snippet()
    {
        $htmlSnippet = HTMLSnippet::factory()->create();

        $input = [
            'title' => 'Updated title'
        ];

        $response = $this->json('PATCH', route('html-snippets.update', $htmlSnippet), $input);
        $response->assertOk()
            ->assertJsonFragment([
                'title' => $input['title']
            ]);
    }

    /**
     * @test
     */
    public function test_it_deletes_html_snippet()
    {
        $htmlSnippet = HTMLSnippet::factory()->create();

        $response = $this->json('DELETE', route('html-snippets.destroy', $htmlSnippet));
        $response->assertStatus(204);
    }
}