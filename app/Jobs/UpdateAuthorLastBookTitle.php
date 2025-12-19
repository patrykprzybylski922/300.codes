<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAuthorLastBookTitle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $bookId
    ) {}

    public function handle(): void
    {
        $book = Book::with('authors')->find($this->bookId);

        if (! $book) {
            return;
        }

        foreach ($book->authors as $author) {
            $author->update([
                'last_book_title' => $book->title,
            ]);
        }

        \Log::info('UpdateAuthorLastBookTitle job executed', [
            'book_id' => $this->bookId,
        ]);
    }
}
