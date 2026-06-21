<?php

namespace App\Services\Event;

use App\Actions\Event\CreateEventAction;
use App\Actions\Event\DeleteEventAction;
use App\Actions\Event\UpdateEventAction;
use App\DTOs\EventDTO;
use App\Models\MDiklat;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    public function __construct(
        private readonly CreateEventAction $createAction,
        private readonly UpdateEventAction $updateAction,
        private readonly DeleteEventAction $deleteAction,
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return MDiklat::query()
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where('nama', 'like', "%{$v}%"))
            ->when($filters['tahun'] ?? null,  fn($q, $v) => $q->whereYear('tglJamMulai', $v))
            ->latest()
            ->paginate(15);
    }

    public function create(EventDTO $dto): MDiklat
    {
        return $this->createAction->execute($dto);
    }

    public function update(MDiklat $diklat, EventDTO $dto): MDiklat
    {
        return $this->updateAction->execute($diklat, $dto);
    }

    public function delete(MDiklat $diklat): bool
    {
        return $this->deleteAction->execute($diklat);
    }

    public function toggleQr(MDiklat $diklat): void
    {
        $diklat->update(['IsActive' => !$diklat->IsActive]);
    }
}