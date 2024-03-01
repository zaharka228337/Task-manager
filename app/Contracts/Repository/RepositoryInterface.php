<?php

declare(strict_types = 1);

namespace App\Contracts\Repository;

use App\Services\TaskManager\TaskDTO\TaskDataTransferObject;

interface RepositoryInterface
{
    public function all(): array;
    public function create(TaskDataTransferObject $dataTransferObject): void;
    public function update(TaskDataTransferObject $dataTransferObject): TaskDataTransferObject;
    public function delete(int $id): void;
    public function getById(int $id): TaskDataTransferObject;
}
