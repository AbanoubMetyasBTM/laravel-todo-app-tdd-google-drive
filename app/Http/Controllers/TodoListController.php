<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\TodoList\SaveTodoListRequest;
use App\Models\TodoListModel;
use Illuminate\Http\Response;

class TodoListController extends Controller
{

    public function index()
    {
        $userId = auth()->user()->id;
        $lists  = TodoListModel::getUserLists($userId);

        return ResponseHelper::returnSuccess([
            "lists" => $lists
        ]);
    }

    public function show(int $listId)
    {
        $userId = auth()->user()->id;

        $list = TodoListModel::getUserListId($userId, $listId);
        if(!is_object($list)){
            return ResponseHelper::returnError("no list found", Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::returnSuccess([
            "list" => $list
        ]);
    }

    public function store(SaveTodoListRequest $request){
        $userId = auth()->user()->id;

        $list = TodoListModel::createNewList($userId, $request->get("list_title"));

        return ResponseHelper::returnSuccess([
            "list" => $list
        ], Response::HTTP_CREATED);
    }

    public function update(SaveTodoListRequest $request, int $listId){
        $userId = auth()->user()->id;

        $list = TodoListModel::getUserListId($userId, $listId);
        if(!is_object($list)){
            return ResponseHelper::returnError("no list found", Response::HTTP_NOT_FOUND);
        }

        $list->update([
            "list_title" => $request->get("list_title")
        ]);

        return ResponseHelper::returnSuccess([
            "list" => $list
        ]);
    }


    public function destroy(int $listId){
        $userId = auth()->user()->id;

        $list = TodoListModel::getUserListId($userId, $listId);
        if(!is_object($list)){
            return ResponseHelper::returnError("no list found", Response::HTTP_NOT_FOUND);
        }

        $list->delete();

        return ResponseHelper::returnSuccess([], Response::HTTP_NO_CONTENT);
    }



}
