<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Http\Requests\OuRequest;
use App\Models\CalculationFormulaModel;
use App\Models\Cores\Cores_ou;
use App\Models\Cores\Cores_ou_meta;
use App\Models\Cores\Cores_ou_survey;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Models\QuestionFormModel;
use App\Models\QuestionModel;
use App\Models\RequestReevaluationModel;
use App\Models\RoundModel;
use App\Models\RoundOuModel;
use App\Models\Sipas\SipasQuestionFormModel;
use App\Models\Sipas\SipasQuestionModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OuCtrl extends RestController
{

    public function insert(OuRequest $request, Cores_ou $cores_ou)
    {
        if (!in_array($request->ou_level, $cores_ou->get_ou_level())) {
            return response()->json(['data' => ['errors' => 'Cấp đơn vị không hợp lệ']], 422);
        }
        if (!empty($request->latitude) || !empty($request->longitude)) {
            $check = $this->validateLatLong($request->latitude, $request->longitude);
            if (!$check) {
                return response()->json(['errors' => ['longitude' => ['Kinh độ hoặc vĩ độ không hợp lệ']]], 422);
            }
        }
        try {
            if (Auth::user()->root_ou_id) {
                if ($request->input('ou_level') != Cores_ou::_CONST_CAP_PHONG_BAN &&
                    $request->input('ou_level') != Cores_ou::_CONST_CAP_XA) {
                    return response()->json(['message' => "Bạn chỉ được thêm phòng ban hoặc cấp xã!"], 422);
                }
            }

            $v_ou_id = $cores_ou->addNew($request->input('ou_name'), $request->input('ou_level'), (int)$request->input('ou_order'), (int)$request->input('parent_id'), $request->latitude, $request->longitude, $request->radius);
            if (Auth::user()->root_ou_id) {
                Cores_ou_meta::makeInstance()->updateOuMeta($v_ou_id, Cores_ou_meta::_CONST_EMAIL, $request->email);
                Cores_ou_meta::makeInstance()->updateOuMeta($v_ou_id, Cores_ou_meta::_CONST_SMS, $request->sms);
            }

        } catch (\Exception $ex) {
            return response()->json(['data' => ['errors' => $ex->getMessage()]], 500);
        }

        return response()->json([]);
    }

    public function edit(OuRequest $request, Cores_ou $Cores_ou)
    {
        try {
            if (Auth::user()->root_ou_id) {
                if ($request->input('ou_level') != Cores_ou::_CONST_CAP_PHONG_BAN &&
                    $request->input('ou_level') != Cores_ou::_CONST_CAP_XA) {
                    return response()->json(['message' => "Bạn chỉ được cập nhật phòng ban hoặc cấp xã!"], 422);
                }
            }
            if (!empty($request->latitude) || !empty($request->longitude)) {
                $check = $this->validateLatLong($request->latitude, $request->longitude);
                if (!$check) {
                    return response()->json(['errors' => ['longitude' => ['Kinh độ hoặc vĩ độ không hợp lệ']]], 422);
                }
            }
            $Cores_ou->edit($request->id, $request->input('ou_name'), $request->input('ou_level'), (int)$request->input('ou_order'), (int)$request->input('parent_id'), $request->latitude, $request->longitude, $request->radius);
            if (Auth::user()->user_is_admin) {
                Cores_ou_meta::makeInstance()->updateOuMeta($request->id, Cores_ou_meta::_CONST_EMAIL, $request->email);
                Cores_ou_meta::makeInstance()->updateOuMeta($request->id, Cores_ou_meta::_CONST_SMS, $request->sms);
            }

        } catch (\Exception $ex) {
            return response()->json(['data' => ['errors' => $ex->getMessage()]], 500);
        }


        return response()->json([]);
    }

    /**
     * Get single ou
     * @OA\Get(path="/rest/ou/{id}",
     *   tags={"Ou"},
     *   summary="Get ou by ou ID",
     *   description="",
     *   operationId="getOuById",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The name that needs to be fetched. Use ou1 for testing. ",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Ou")),
     *   @OA\Response(response=400, description="Invalid ouname supplied"),
     *   @OA\Response(response=404, description="Ou not found")
     * )
     */
    function getSingle(Request $request, Cores_ou $cores_ou)
    {
        $resp        = $cores_ou::findOrFail($request->id);
        $resp->email = Cores_ou_meta::makeInstance()->getOuMeta($request->id, Cores_ou_meta::_CONST_EMAIL);
        $resp->sms   = Cores_ou_meta::makeInstance()->getOuMeta($request->id, Cores_ou_meta::_CONST_SMS);
        return response()->json($resp);
    }

    /**
     * Get all ou
     *
     * @param  \App\Models\Cores\Cores_ou $cores_ou
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(path="/rest/ou",
     *   tags={"Ou"},
     *   summary="Get all ous",
     *   description="",
     *   operationId="getAllOu",
     *
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Ou")),
     *   @OA\Response(response=400, description="Invalid ouname supplied"),
     *   @OA\Response(response=404, description="Ous not found")
     * )
     *
     */
    public function getAll(Request $request, Cores_ou $cores_ou)
    {
        $params = $request->all();
        $params['verify'] = $params['verify'] ?? 1;
        $resp = $cores_ou->getAll($params);
        return response()->json($resp);
    }

    public function receivedNotificationOu(Request $request, Cores_ou $cores_ou)
    {
        $resp = $cores_ou->getAllReceivedNotificationOu($request->ou_level);
        return response()->json($resp);
    }

    public function getAllNested(Request $request, Cores_ou $cores_ou)
    {
        $resp = $cores_ou->getAllNested();
        return response()->json($resp);
    }

    /**
     * Lấy danh sách ou cho đợt đánh giá
     *
     * @OA\Get(path="/rest/ou/forEvaluationRound",
     *   tags={"Ou"},
     *   summary="Get all ous for Evaluation Round",
     *   description="",
     *   operationId="getAllOuForEvaluationRound",
     *
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Ou")),
     *   @OA\Response(response=400, description="Invalid ouname supplied"),
     *   @OA\Response(response=404, description="Ous not found")
     * )
     *
     */
    public function getAllOuForEvaluationRound(Request $request, Cores_ou $cores_ou)
    {
        $resp = $cores_ou->getAllOuForEvaluationRound($request->ou_level);
        return response()->json($resp);
    }

    /**
     * Get all ou and user
     * @OA\Get(path="/rest/ou/allOuAndOuSurvey",
     *   tags={"Ou"},
     *   summary="Get department ou",
     *   description="",
     *   operationId="getAllOuAndOuSurvey",
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Ou")),
     *   @OA\Response(response=400, description="Invalid ouname supplied"),
     *   @OA\Response(response=404, description="Ou not found")
     * )
     */
    function getAllOuAndOuSurvey($ou_id, Request $request, Cores_ou $cores_ou)
    {
        $data = $cores_ou->getAllOuAndOuSurvey($ou_id, $request->ou_survey_id);
        return response()->json($data);
    }

    /**
     * Get all ou and user
     * @OA\Get(path="/rest/ou/allOuAndUser",
     *   tags={"Ou"},
     *   summary="Get department ou",
     *   description="",
     *   operationId="getAllOuAndUser",
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Ou")),
     *   @OA\Response(response=400, description="Invalid ouname supplied"),
     *   @OA\Response(response=404, description="Ou not found")
     * )
     */
    function getAllOuAndUser($id_parent, Cores_ou $cores_ou)
    {
        $allGroups = $cores_ou->getAllOuAndUser($id_parent);
        return response()->json($allGroups);
    }

    /**
     * Get department ou
     * @OA\Get(path="/rest/ou/getDepartment/{parent_id}",
     *   tags={"Ou"},
     *   summary="Get department ou",
     *   description="",
     *   operationId="getDepartment",
     *   @OA\Parameter(
     *     name="parent_id",
     *     in="path",
     *     description="The name that needs to be fetched. Use ou1 for testing. ",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/Ou")),
     *   @OA\Response(response=400, description="Invalid ouname supplied"),
     *   @OA\Response(response=404, description="Ou not found")
     * )
     */
    function getDepartment(Request $request, Cores_ou $cores_ou)
    {
        $allDepartment = $cores_ou::where('parent_id', $request->id_parent)->where('ou_level', Cores_ou::_CONST_CAP_PHONG_BAN)->get();
        return response()->json($allDepartment);
    }

    public function destroy($ou_id)
    {
        Cores_ou::findOrFail($ou_id);
        //check đơn vị có trong các bảng  cores_ou_survey; cores_ous; users;t_calculation_formula
        //t_question; t_question_form; t_round; t_round_ou; t_sipas_question; t_sipas_question_form
        //
        $count = Cores_ou_survey::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị có đơn vị khảo sát trực thuộc!', [], 422);
        }
        $count = Cores_ou::where('parent_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị có đơn vị trực thuộc!', [], 422);
        }
        $count = User::where('ou_id', $ou_id)->orWhere('root_ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị có người sử dụng trực thuộc!', [], 422);
        }
        $count = CalculationFormulaModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã tạo công thức tính!', [], 422);
        }
        $count = QuestionModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã tạo câu hỏi!', [], 422);
        }
        $count = QuestionFormModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã tạo mẫu phiếu!', [], 422);
        }
        $count = RoundModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã tạo đợt đánh giá!', [], 422);
        }
        $count = RoundOuModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã được đánh giá!', [], 422);
        }
        $count = SipasQuestionModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã tạo câu hỏi điều tra xhh!', [], 422);
        }
        $count = SipasQuestionFormModel::where('ou_id', $ou_id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được đơn vị đã tạo mẫu điều tra xhh!', [], 422);
        }
        Cores_ou::where('ou_id', $ou_id)->delete();
        return response()->json([]);
    }

    function updateOuOld()
    {
        $arr_user = Cores_user::where('ou_id', 0)->get();
        foreach ($arr_user as &$user) {
            $ou_parent = Cores_user_meta::leftJoin('cores_ous', 'ou_id', '=', 'user_meta_value')->where([
                ['user_meta_key', 'OU_PARENT'],
                ['user_id', $user->id],

            ])->orderBy('ou_id', 'DESC')->first();

            if (!is_null($ou_parent)) {
                if ($ou_parent->parent_id > 0) {
                    $user->root_ou_id = $ou_parent->parent_id;
                } elseif ($ou_parent->ou_level == Cores_ou::_CONST_CAP_SO || $ou_parent->ou_level == Cores_ou::_CONST_CAP_TINH || $ou_parent->ou_level == Cores_ou::_CONST_CAP_HUYEN) {
                    $user->root_ou_id = $ou_parent->ou_id;
                } else {
                    $user->root_ou_id = 0;
                }
                $user->ou_id = $ou_parent->ou_id;
                $user->save();
            }


        }
    }

    /*
     * Kiểm tra khoảng cách
     */
    function checkDistance($ou_id, $latitude, $longitude)
    {

        $ouInfo = Cores_ou::find($ou_id);
        if (is_null($ouInfo) || empty($ouInfo->latitude) || empty($ouInfo->longitude) || empty($ouInfo->longitude)) {
            return true;
        }
        $distance = $this->getDistance($ouInfo->latitude, $ouInfo->longitude, $latitude, $longitude);
        if ($distance > $ouInfo->radius) {
            return false;
        }
        return true;
    }

    /**
     * Validates a given coordinate
     *
     * @param float|int|string $lat Latitude
     * @param float|int|string $long Longitude
     * @return bool `true` if the coordinate is valid, `false` if not
     */
    public function validateLatLong($lat, $long)
    {
        if (empty($lat) || empty($long)) {
            return 0;
        }
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $lat . ',' . $long);
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        //Bán kính trái đất
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }

}
