<?php

namespace Tests\Feature;

use App\Models\PdfFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PdfFileTest extends TestCase
{
    use RefreshDatabase;
    use withFaker;

    /**
     * @test
     */
    public function test_it_lists_pdf_files()
    {
        PdfFile::factory(6)->create();

        $response = $this->json('GET', route('pdf-files.index'));
        $response->assertOk()
            ->assertJsonCount(6, 'data');
    }

    /**
     * @test
     */
    public function test_it_adds_a_pdf_file()
    {
        $input = [
            'title' => $this->faker->words(3, true),
            'file' => UploadedFile::fake()->create('document.pdf', 1)
        ];

        $response = $this->json('POST', route('pdf-files.store'), $input);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => $input['title']
            ]);
    }

    /**
     * @test
     */
    public function test_it_views_a_pdf_file()
    {
        $file = PdfFile::factory()->create();

        $response = $this->json('GET', route('pdf-files.show', $file));
        $response->assertOk()
            ->assertJsonFragment([
                'id' => $file->id,
                'title' => $file->title,
                'file' => "/storage/" . $file->file
            ]);
    }

    /**
     * @test
     */
    public function test_it_updates_a_pdf_file()
    {
        $file = PdfFile::factory()->create();

        $input = [
            'title' => 'Updated title',
            'file' => UploadedFile::fake()->create('document.pdf', 1)
        ];

        $response = $this->json('PATCH', route('pdf-files.update', $file), $input);
        $response->assertOk()
            ->assertJsonFragment([
                'title' => $input['title'],
                'file' => $input['file']
            ]);
    }

    /**
     * @test
     */
    public function test_it_deletes_pdf_file()
    {
        $file = PdfFile::factory()->create();

        $response = $this->json('DELETE', route('pdf-files.destroy', $file));
        $response->assertStatus(204);
    }
}
