<?php

declare(strict_types = 1);

namespace App\Services\TaskManager\Repository;

use App\Contracts\Repository\RepositoryInterface;
use App\Models\Task;
use App\Services\TaskManager\TaskDTO\TaskDataTransferObject;

class TaskRepository implements RepositoryInterface
{
    private array $DTOCollection = [];

    public function __construct(
        private readonly Task $model
    ) {
    }

    /**
     * Запрашивает все записи из базы.
     *
     * @return array
     */
    public function all(): array
    {
        $models = $this->model
            ->get()
            ->toArray();

        return $this->toDTOCollection($models);
    }

    /**
     * Создает новую запись в базе.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return void
     */
    public function create(TaskDataTransferObject $dataTransferObject): void
    {
        $this->model->create([
            'name'          => $dataTransferObject->name,
            'description'   => $dataTransferObject->description,
            'status'        => $dataTransferObject->isDone,
            'date_start'    => $dataTransferObject->date_start,
            'date_deadline' => $dataTransferObject->date_deadline
        ]);
    }

    /**
     * Обновляет одну запись в базе.
     *
     * @param TaskDataTransferObject $dataTransferObject
     * @return TaskDataTransferObject
     */
    public function update(TaskDataTransferObject $dataTransferObject): TaskDataTransferObject
    {
        $model = $this->model
            ->findOrFail($dataTransferObject->id)
            ->fill([
                'name'          => $dataTransferObject->name,
                'description'   => $dataTransferObject->description,
                'status'        => $dataTransferObject->isDone,
                'date_start'    => $dataTransferObject->date_start,
                'date_deadline' => $dataTransferObject->date_deadline
            ])
            ->save()
            ->get()
            ->toArray();

        return $this->toDTO($model);
    }

    /**
     * Удаляет одну запись в базе по идентификатору.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->model
            ->findOrFail($id)
            ->get()
            ->delete();
    }

    /**
     * Запрашивает одну запись из базы по идентификатору.
     *
     * @param int $id
     * @return TaskDataTransferObject
     */
    public function getById(int $id): TaskDataTransferObject
    {
        $model = $this->model
            ->findOrFail($id)
            ->get()
            ->toArray();

        return $this->toDTO($model);
    }

    /**
     * Запрашивает все отфильтрованные записи по дате и статусу.
     *
     * @param bool $status
     * @param string $deadline
     * @return array
     */
    public function filter(
        bool $status,
        string $deadline
    ): array
    {
        $models = $this->model
            ->where('status', $status)
            ->whereDate('deadline', '>', $deadline)
            ->union(
                $this->model->whereDate('deadline', '<', $deadline)
            )
            ->get()
            ->toArray();

        return $this->toDTOCollection($models);
    }

    /**
     * Возвращает коллекцию DTO задач.
     *
     * @param array $arrayModels
     * @return array
     */
    private function toDTOCollection(array $arrayModels): array
    {
        foreach($arrayModels as $arrayModel)
        {
            $this->DTOCollection[] = TaskDataTransferObject::create()
                ->setID($arrayModel['id'])
                ->setName($arrayModel['name'])
                ->setDescription($arrayModel['description'])
                ->setStatus($arrayModel['status'])
                ->setStartDate($arrayModel['date_start'])
                ->setDeadlineDate($arrayModel['date_deadline']);
        }

        return $this->DTOCollection;
    }

    /**
     * Возвращает DTO задачи.
     *
     * @param array $arrayModel
     * @return TaskDataTransferObject
     */
    private function toDTO(array $arrayModel): TaskDataTransferObject
    {
        return TaskDataTransferObject::create()
            ->setID($arrayModel['id'])
            ->setName($arrayModel['name'])
            ->setDescription($arrayModel['description'])
            ->setStatus($arrayModel['status'])
            ->setStartDate($arrayModel['date_start'])
            ->setDeadlineDate($arrayModel['date_deadline']);
    }
}
