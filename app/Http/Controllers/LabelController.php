<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Label\SaveLabelRequest;
use App\Models\LabelModel;
use Illuminate\Http\Response;

class LabelController extends Controller
{

    public function index()
    {
        $userId = auth()->user()->id;

        $labels = LabelModel::getUserLabels($userId);

        return ResponseHelper::returnSuccess([
            "labels" => $labels
        ]);
    }

    public function store(SaveLabelRequest $request)
    {
        $userId = auth()->user()->id;

        $request["user_id"] = $userId;
        $label              = LabelModel::createNewLabel($request->all());

        return ResponseHelper::returnSuccess([
            "label" => $label
        ], Response::HTTP_CREATED);
    }

    public function update(SaveLabelRequest $request, int $labelId)
    {
        $userId = auth()->user()->id;

        $label = LabelModel::getUserLabel($userId, $labelId);
        if (!is_object($label)) {
            return ResponseHelper::returnError("no label found", Response::HTTP_NOT_FOUND);
        }

        LabelModel::updateLabel($label, $request->all());

        return ResponseHelper::returnSuccess([
            "label" => $label
        ]);
    }


    public function destroy(int $labelId)
    {
        $userId = auth()->user()->id;

        $label = LabelModel::getUserLabel($userId, $labelId);
        if (!is_object($label)) {
            return ResponseHelper::returnError("no label found", Response::HTTP_NOT_FOUND);
        }

        $label->delete();

        return ResponseHelper::returnSuccess([], Response::HTTP_NO_CONTENT);
    }


}
