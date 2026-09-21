<?php

declare(strict_types=1);

namespace Beaver\Plugins\Skeleton\Services;

use Beaver\Plugins\Skeleton\Models\Note;

/**
 * Lógica de negócio para Notes.
 */
class NoteService
{
    /** @return Note[] */
    public function all(): array
    {
        return Note::query()->orderBy('id', 'desc')->get();
    }

    public function find(int $id): ?Note
    {
        return Note::find($id);
    }

    public function create(string $title, string $body = ''): Note
    {
        return Note::create([
            'title' => $title,
            'body'  => $body,
        ]);
    }

    public function delete(int $id): bool
    {
        $note = $this->find($id);
        return $note ? $note->delete() : false;
    }
}