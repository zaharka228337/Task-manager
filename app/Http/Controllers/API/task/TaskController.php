<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API\task;

use App\Http\Controllers\Controller;
use App\Services\TaskManagementService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TaskManager\TaskDTO\TaskDataTransferObject;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskManagementService $managementService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->managementService->getAllRecords());
    }

    public function create(Request $request): JsonResponse
    {
        $taskDTO = $this->createTaskDTOByValidatedData($request);

        try {
            $this->managementService->createRecord($taskDTO);

            return response()->json(['message' => 'Record created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the record'], 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $taskDTO = $this->createTaskDTOByValidatedData($request);

        return response()->json($this->managementService->updateRecord($taskDTO));
    }

    public function destroy(int $id): JsonResponse
    {
        $taskDTO = TaskDataTransferObject::create()
            ->setID($id);

        try {
            $this->managementService->deleteRecord($taskDTO);

            return response()->json(['message' => 'Record deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the record'], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        $taskDTO = TaskDataTransferObject::create()
            ->setID($id);

        return response()->json($this->managementService->getRecordByID($taskDTO));
    }

    public function filter(Request $request): JsonResponse
    {
        $taskDTO = TaskDataTransferObject::create()
            ->setStatus($request->get('status'))
            ->setDeadlineDate($request->get('date_deadline'));

        return response()->json($this->managementService->getFilteredRecordsByDateAndStatus($taskDTO));
    }

    private function createTaskDTOByValidatedData(Request $request): TaskDataTransferObject
    {
        $validated = $request->validate([
            'name'          => ['string | max:255 | required | min:8'],
            'description'   => ['string | max:1000 | required'],
            'status'        => ['boolean | required'],
            'date_start'    => ['string | required'],
            'date_deadline' => ['string | required'],
        ]);

        return TaskDataTransferObject::create()
            ->setName($validated['name'])
            ->setDescription($validated['description'])
            ->setStatus($validated['status'])
            ->setStartDate($validated['date_start'])
            ->setDeadlineDate($validated['date_deadline']);
    }
}
