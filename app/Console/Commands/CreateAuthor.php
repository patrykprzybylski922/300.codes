<?php

namespace App\Console\Commands;

use App\Services\AuthorService;
use Illuminate\Console\Command;

class CreateAuthor extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'author:create';

    /**
     * The console command description.
     */
    protected $description = 'Create a new author by providing first and last name';

    public function __construct(
        private AuthorService $authorService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $firstName = $this->ask('Enter author first name');
        $lastName  = $this->ask('Enter author last name');

        if (! $firstName || ! $lastName) {
            $this->error('First name and last name are required.');
            return self::FAILURE;
        }

        $author = $this->authorService->create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
        ]);

        $this->info('Author created successfully!');
        $this->line("ID: {$author->id}");
        $this->line("Name: {$author->first_name} {$author->last_name}");

        return self::SUCCESS;
    }
}
