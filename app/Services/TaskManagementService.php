<?php

declare(strict_types = 1);

namespace App\Services;

use App\Services\TaskManager\Repository\TaskRepository;
use App\Services\TaskManager\TaskDTO\TaskDataTransferObject;

class TaskManagementService
{
    public function __construct(
        private readonly TaskRepository $taskRepository
    ) {
    }

    /**
     * Возвращает массив DTO обьектов всех записей из базы.
     *
     * @return array
     */
    public function getAllRecords(): array
    {
        return $this->taskRepository->all();
    }

    /**
     * Создает запись из бд по идентификатору.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return void
     */
    public function createRecord(TaskDataTransferObject $dataTransferObject): void
    {
        $this->taskRepository->create($dataTransferObject);
    }

    /**
     * Обновляет запись из базы по идентификатору.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return TaskDataTransferObject
     */
    public function updateRecord(TaskDataTransferObject $dataTransferObject): TaskDataTransferObject
    {
        return $this->taskRepository->update($dataTransferObject);
    }

    /**
     * Удаляет запись из базы по идентификатору.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return void
     */
    public function deleteRecord(TaskDataTransferObject $dataTransferObject): void
    {
        $this->taskRepository->delete($dataTransferObject->id);
    }

    /**
     * Возвращает DTO запись из базы по идентификатору.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return TaskDataTransferObject
     */
    public function getRecordByID(TaskDataTransferObject $dataTransferObject): TaskDataTransferObject
    {
        return $this->taskRepository->getById($dataTransferObject->id);
    }

    /**
     * Возвращает массив DTO обьектов записей из базы.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return array
     */
    public function getFilteredRecordsByDateAndStatus(TaskDataTransferObject $dataTransferObject): array
    {
        return $this->taskRepository->filter(
            $dataTransferObject->isDone,
            $dataTransferObject->date_deadline
        );
    }
}
