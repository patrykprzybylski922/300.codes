<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => "{$this->first_name} {$this->last_name}",
            'last_book_title' => $this->last_book_title,
            'books' => BookResource::collection($this->whenLoaded('books')),
        ];
    }
}
