<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Models\CalculationFormulaDetailModel;
use App\Models\CalculationFormulaModel;
use App\Models\Cores\Cores_group;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_group_meta;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests\GroupRequest;

class GroupCtrl extends RestController
{


    public function insert(GroupRequest $request, Cores_group $Cores_group)
    {
        $groupInfo = [
            'group_name' => $request->group_name,
            'group_code' => $request->group_code,
            'group_status' => $request->group_status
        ];
        $permit = $request->input('permit');
        $users = $request->input('users');
        try {
            $Cores_group->addNew($groupInfo, $permit, $users);
        } catch (\Exception $ex) {
            return response()->json(['data' => ['errors' => $ex->getMessage()]], 500);
        }
        return response()->json([]);
    }

    public function edit(GroupRequest $request, Cores_group $Cores_group)
    {
        $groupInfo = [
            'group_name' => $request->group_name,
            'group_code' => $request->group_code,
            'group_status' => $request->group_status
        ];
        $permit = $request->input('permit');
        $users = $request->input('users');
        try {
            $Cores_group->edit($request->id, $groupInfo, $permit, $users);
        } catch (\Exception $ex) {
            return response()->json(['data' => ['errors' => $ex->getMessage()]], 500);
        }
        return response()->json([]);
    }

    /**
     * Get single group info
     * @OA\Get(path="/rest/group/{id}",
     *   tags={"Group"},
     *   security={{"bearerAuth": {}}},
     *   summary="Get user by group ID",
     *   description="",
     *   operationId="getGroupById",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The ID that needs to be fetched ",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/User")),
     *   @OA\Response(response=400, description="Invalid group supplied"),
     *   @OA\Response(response=404, description="User not found")
     * )
     */
    function getSingle(Request $request, Cores_group $Cores_group)
    {
        $Cores_group::findOrFail($request->id);
        $groupInfo = $Cores_group->getSingle($request->id);
        $groupInfo['users'] = Cores_user_meta::where([
            ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT],
            ['user_meta_value', $request->id],
        ])->pluck('user_id');
        return response()->json($groupInfo);
    }

    /**
     * Get all groups
     *
     * @OA\Get(path="/rest/group",
     *   tags={"Group"},
     *   summary="Get all groups",
     *   description="",
     *   operationId="getAllGroup",
     *
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Group")),
     *   @OA\Response(response=404, description="Groups not found")
     * )
     *
     */
    function getAll(Request $request, Cores_group $Cores_group)
    {

        $allGroups = [
            'data'=> $Cores_group->getAll(),
            'listRole'=> Cores_user::LIST_ROLE
        ]
        ;

        return response()->json($allGroups);
    }

    /**
     * Xoa nhom
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Cores_group::destroy($id);
        return response()->json([]);
    }
}
