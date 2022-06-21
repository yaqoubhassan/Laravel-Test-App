<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Link;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkTest extends TestCase
{
    use RefreshDatabase;
    use withFaker;

    /**
     * @test
     */
    public function test_it_lists_all_links()
    {
        Link::factory(5)->create();
        $response = $this->json('GET', route('links.index'));
        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    /**
     * @test
     */
    public function test_it_adds_a_link()
    {
        $input = [
            'title' => $this->faker->words(3, true),
            'link' => $this->faker->url,
            'open_in_new_tab' => $this->faker->randomElement([true, false])
        ];

        $response = $this->json('POST', route('links.store'), $input);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => $input['title']
            ]);
    }

    /**
     * @test
     */
    public function test_it_views_link()
    {
        $link = Link::factory()->create();

        $response = $this->json('GET', route('links.show', $link));
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $link->id,
                'title' => $link->title,
                'link' => $link->link,
                'open_in_new_tab' => $link->open_in_new_tab
            ]);
    }

    /**
     * @test
     */
    public function test_it_updates_a_link()
    {
        $link = Link::factory()->create();

        $input = [
            'title' => 'Updated title'
        ];

        $response = $this->json('PATCH', route('links.update', $link), $input);
        $response->assertOk()
            ->assertJsonFragment([
                'title' => $input['title']
            ]);
    }

    /**
     * @test
     */
    public function test_it_deletes_link()
    {
        $link = Link::factory()->create();

        $response = $this->json('DELETE', route('links.destroy', $link));
        $response->assertStatus(204);
    }
}
