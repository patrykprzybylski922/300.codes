<?php

namespace Tests\Feature\Api;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_book()
    {
        // given
        $author = Author::create([
            'first_name' => 'George',
            'last_name' => 'Orwell',
        ]);

        $payload = [
            'title' => '1984',
            'year' => 1949,
            'authors' => [$author->id],
        ];

        // when
        $response = $this->postJson('/api/books', $payload);

        // then
        $response
            ->assertStatus(201)
            ->assertJsonPath('data.title', '1984')
            ->assertJsonPath('data.authors.0.id', $author->id);

        $this->assertDatabaseHas('books', [
            'title' => '1984',
        ]);

        $this->assertDatabaseHas('author_book', [
            'author_id' => $author->id,
        ]);
    }

    /** @test */
    public function it_deletes_a_book()
    {
        // given
        $author = Author::create([
            'first_name' => 'George',
            'last_name'  => 'Orwell',
        ]);

        $book = Book::create([
            'title' => 'Animal Farm',
        ]);

        $book->authors()->sync([$author->id]);

        // when
        $response = $this->deleteJson("/api/books/{$book->id}");

        // then
        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);

        $this->assertDatabaseMissing('author_book', [
            'book_id' => $book->id,
        ]);
    }
}
