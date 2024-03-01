<?php

declare(strict_types = 1);

namespace App\Services\TaskManager\TaskDTO;

use App\Contracts\DTO\DataTransferObjectInterface;

class TaskDataTransferObject implements DataTransferObjectInterface
{
    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var bool|null
     */
    public ?bool $isDone;

    /**
     * @var string|null
     */
    public ?string $date_start;

    /**
     * @var string|null
     */
    public ?string $date_deadline;

    /**
     * Устанавливает идентификатор задачи.
     *
     * @param int $id
     * @return $this
     */
    public function setID(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Устанавливает название задачи.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Устанавливает описание задачи.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Устанавливает статус готовности задачи.
     *
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): static
    {
        $this->isDone = $status;

        return $this;
    }

    /**
     * Устанавливает дату постановки задачи.
     *
     * @param string $dateStart
     * @return $this
     */
    public function setStartDate(string $dateStart): static
    {
        $this->date_start = $dateStart;

        return $this;
    }

    /**
     * Устанавливает дату окончания задачи.
     *
     * @param string $dateDeadline
     * @return $this
     */
    public function setDeadlineDate(string $dateDeadline): static
    {
        $this->date_deadline = $dateDeadline;

        return $this;
    }

    /**
     * Инстанцирует DTO.
     *
     * @return static
     */
    public static function create(): self
    {
        return new self();
    }
}
