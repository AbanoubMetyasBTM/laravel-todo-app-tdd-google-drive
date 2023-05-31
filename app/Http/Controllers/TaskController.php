<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Task\SaveTaskRequest;
use App\Models\TaskModel;
use App\Models\TodoListModel;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;

class TaskController extends Controller
{

    private function checkTodoListOwnership($todoListId)
    {
        $userId      = auth()->user()->id;
        $todoListObj = TodoListModel::getUserListId($userId, $todoListId);
        if (!is_object($todoListObj)) {
            return [
                "error" => ResponseHelper::returnError(
                    "invalid list",
                    Response::HTTP_NOT_FOUND
                ),
            ];
        }

        return $todoListObj;
    }

    public function index(int $todoListId)
    {

        $todoListObj = $this->checkTodoListOwnership($todoListId);
        if (isset($todoListObj["error"])) {
            return $todoListObj["error"];
        }

        $tasks = TaskModel::getTodoListTasks($todoListId);

        return ResponseHelper::returnSuccess([
            "list"  => $todoListObj,
            "tasks" => $tasks,
        ]);
    }

    public function store(SaveTaskRequest $request, int $todoListId)
    {

        $todoListObj = $this->checkTodoListOwnership($todoListId);
        if (isset($todoListObj["error"])) {
            return $todoListObj["error"];
        }

        $data            = $request->validated();
        $data["list_id"] = $todoListId;

        $newTask = TaskModel::saveTask($data);

        return ResponseHelper::returnSuccess([
            "task" => $newTask,
        ], Response::HTTP_CREATED);
    }

    public function update(int $todoListId, int $taskId, Request $request)
    {

        $todoListObj = $this->checkTodoListOwnership($todoListId);
        if (isset($todoListObj["error"])) {
            return $todoListObj["error"];
        }

        $task = TaskModel::findOrFail($taskId);
        if ($task->list_id != $todoListId){
            return ResponseHelper::returnError(
                "invalid list",
                Response::HTTP_NOT_FOUND
            );
        }

        TaskModel::updateTask($task, $request->all());

        return ResponseHelper::returnSuccess([
            "task" => $task,
        ]);
    }

    public function destroy(int $todoListId, int $taskId)
    {
        $todoListObj = $this->checkTodoListOwnership($todoListId);
        if (isset($todoListObj["error"])) {
            return $todoListObj["error"];
        }

        $task = TaskModel::findOrFail($taskId);
        if ($task->list_id != $todoListId){
            return ResponseHelper::returnError(
                "invalid list",
                Response::HTTP_NOT_FOUND
            );
        }

        TaskModel::destroy($taskId);

        return response('', Response::HTTP_NO_CONTENT);
    }


}
