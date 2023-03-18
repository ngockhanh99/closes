<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Message;
use App\Models\Cores\Cores_Media;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Models\Cores\Cores_ou;
use App\Models\NotificationModel;
use App\Models\RoundFormAssignmentModel;
use App\Models\RoundFormExpertiseModel;
use App\Models\RoundOuFormValueMetaModel;
use App\Models\RoundOuFormValueModel;
use App\Models\Sipas\SipasAssignmentImportModel;
use App\Models\Sipas\SipasQuestionFormValueModel;
use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Cores\Cores_group;
use App\Models\Cores\Cores_group_meta;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserCtrl extends RestController
{

    /**
     * Get single user
     * @OA\Get(path="/rest/user/{id}",
     *   tags={"User"},
     *   summary="Get user by user ID",
     *   description="",
     *   operationId="getUserById",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The name that needs to be fetched. Use user1 for testing. ",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/User")),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=404, description="User not found")
     * )
     */
    function getSingle(Request $request, Cores_user $Cores_user)
    {
        $userInfo = $Cores_user->getSingle($request->id);
        return response()->json($userInfo);
    }

    /**
     * Get all user
     *
     * @OA\Get(path="/rest/user",
     *   tags={"User"},
     *   summary="Get all users",
     *   description="",
     *   operationId="getAllUser",
     *
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/User")),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=404, description="Users not found")
     * )
     *
     */
    public function getAll(Request $request, Cores_user $cores_ou)
    {
        $v_limit = $request->page_size ? $request->page_size : 25;
        return $cores_ou->getAll($v_limit, $request->ou_id, $request->permit, $request->keywords, $request->full_option);
    }
    public function getListUser()
    {
        $group_id = Cores_group::where('group_code', 'CO_QUAN')->first()->group_id;
        $list_user = [];
        $user_id = Cores_user_meta::where('user_meta_value', $group_id)
            ->where('user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT)->pluck('user_id')->all();

        $list_user = Cores_user::whereIn('id', $user_id)->get();

        return response()->json($list_user);
    }

    public function insert(UserRequest $request, Cores_user $Cores_user)
    {
        $is_admin   = \Illuminate\Support\Facades\Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $user_email = $request->input('user_email') ? $request->input('user_email') : null;

        //Build userInfo
        $userInfo = [
            'user_login_name' => $user_email,
            'user_email'      => $request->input('user_email'),
            'user_name'       => $request->input('user_name'),
            'user_email'      => $user_email,
            'password'        => $request->input('password'),
            'ou_id'           => $request->input('ou_id'),
            'user_order'      => $request->input('user_order'),
            'user_status'     => $request->input('user_status'),
            'user_is_admin'   => $is_admin ? $request->input('user_is_admin') : false,
            'user_role'     => $request->input('user_role'),
            'type_id'     => $request->input('type_id'),
            'spec_id'     => $request->input('spec_id'),
            'province_id'     => $request->input('province_id'),
            'district_id'     => $request->input('district_id'),
            'village_id'     => $request->input('village_id'),
            'verified'     => $request->input('verified'),
        ];
        //Bui userOther
        $userOther = [
            'user_address'   => $request->input('user_address'),
            'user_job_title' => $request->input('user_job_title'),
            'user_phone'     => $request->input('user_phone'),
            'enterprise_name' => $request->input('enterprise_name'),
            'enterprise_website' => $request->input('enterprise_website'),
        ];

        // $ouInfo = Cores_ou::find($request->input('ou_id'));
        // if (is_null($ouInfo)) {
        //     return $this->response('Mã đơn vị không đúng!', ['ou_id' => ['Đơn vị trực thuộc không hợp lệ']], 422);
        // }
        // if ($ouInfo->parent_id > 0) {
        //     $userInfo['root_ou_id'] = $ouInfo->parent_id;
        // } elseif ($ouInfo->ou_level == Cores_ou::_CONST_CAP_SO || $ouInfo->ou_level == Cores_ou::_CONST_CAP_TINH || $ouInfo->ou_level == Cores_ou::_CONST_CAP_HUYEN) {
        //     $userInfo['root_ou_id'] = $ouInfo->ou_id;
        // } else {
        //     $userInfo['root_ou_id'] = 0;
        // }

        // Build Group Chosen
        $arrGroupChosen = is_array($request->input('groups')) ? $request->input('groups') : [];

        //Build unit chosen
        $arrPermitChosen = is_array($request->input('permit')) ? $request->input('permit') : [];

        $resp = $Cores_user->insertUser($userInfo, $userOther, $arrGroupChosen, [], $arrPermitChosen);
        return response()->json([$resp]);
    }


    public function update(UserRequest $request, Cores_user $Cores_user)
    {
        $is_admin   = \Illuminate\Support\Facades\Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $user_email = $request->input('user_email') ? $request->input('user_email') : null;
        //Build userInfo
        $userInfo = [
            'id'              => $request->id,
            'user_login_name' => $user_email,
            'user_email'      => $request->input('user_email'),
            'user_name'       => $request->input('user_name'),
            'user_email'      => $user_email,
            'password'        => $request->input('password'),
            'ou_id'           => $request->input('ou_id'),
            'user_order'      => $request->input('user_order'),
            'user_status'     => $request->input('user_status'),
            'user_is_admin'   => $is_admin ? $request->input('user_is_admin') : false,
            'user_role'     => $request->input('user_role'),
            'type_id'     => $request->input('type_id'),
            'spec_id'     => $request->input('spec_id'),
            'province_id'     => $request->input('province_id'),
            'district_id'     => $request->input('district_id'),
            'village_id'     => $request->input('village_id'),
            'verified'     => $request->input('verified'),
        ];
        //Bui userOther
        $userOther = [
            'user_address'   => $request->input('user_address'),
            'user_job_title' => $request->input('user_job_title'),
            'user_phone'     => $request->input('user_phone'),
            'enterprise_name' => $request->input('enterprise_name'),
            'enterprise_website' => $request->input('enterprise_website'),
        ];

        // $ouInfo = Cores_ou::find($request->input('ou_id'));
        // if (is_null($ouInfo)) {
        //     return $this->response('Mã đơn vị không đúng!', ['ou_id' => ['Đơn vị trực thuộc không hợp lệ']], 422);
        // }
        // if ($ouInfo->parent_id > 0) {
        //     $userInfo['root_ou_id'] = $ouInfo->parent_id;
        // } elseif ($ouInfo->ou_level == Cores_ou::_CONST_CAP_SO || $ouInfo->ou_level == Cores_ou::_CONST_CAP_TINH || $ouInfo->ou_level == Cores_ou::_CONST_CAP_HUYEN) {
        //     $userInfo['root_ou_id'] = $ouInfo->ou_id;
        // } else {
        //     $userInfo['root_ou_id'] = 0;
        // }

        //Build Group Chosen
        $arrGroupChosen = is_array($request->input('groups')) ? $request->input('groups') : [];

        //Build unit chosen
        $arrPermitChosen = is_array($request->input('permit')) ? $request->input('permit') : [];

        $resp = $Cores_user->edit($userInfo, $userOther, $arrGroupChosen, [], $arrPermitChosen);
        return response()->json([$resp]);
    }


    public function destroy(Request $request)
    {
        Cores_user::findOrFail($request->id);
        //kiểm tra người dùng đã sử dụng phần mềm chưa
        //bảng cores_media; t_round_form_value_meta; t_sipas_question_form_value
        $count = RoundOuFormValueMetaModel::where('user_id', $request->id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được người dùng đã chấm điểm!', [], 422);
        }
        $count = Cores_Media::where('user_id', $request->id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được người dùng đã đính kèm tài liệu!', [], 422);
        }
        $count = SipasQuestionFormValueModel::where('user_id', $request->id)->count();
        if ($count > 0) {
            return $this->response('Không xóa được người dùng đã nhập phiếu khảo sát!', [], 422);
        }
        //xóa người dùng trong bảng messages; notifications; t_round_form_assignment; t_round_form_expertise;
        // t_sipas_assignment_import
        Message::where('user_id', $request->id)->delete();
        NotificationModel::where('created_by', $request->id)->delete();
        RoundFormAssignmentModel::where('user_id', $request->id)->delete();
        RoundFormExpertiseModel::where('user_id', $request->id)->delete();
        SipasAssignmentImportModel::where('user_id', $request->id)->delete();
        Cores_user::destroy($request->id);
        return response()->json([]);
    }

    /**
     * Lấy danh sách cán bộ có quyền thẩm định

     */
    function getAllAssign(Cores_user $userModel)
    {
        $root_ou_id = !empty(Auth::user()->root_ou_id) ? Auth::user()->root_ou_id : null;
        $arr_user   = $userModel->getUserByRole('expertise', [], $root_ou_id);
        return response()->json($arr_user);
    }

    function getAllAssignCheck(Cores_user $userModel)
    {
        $root_ou_id = !empty(Auth::user()->root_ou_id) ? Auth::user()->root_ou_id : null;
        $arr_user   = $userModel->getUserByRole('check-expertise', [], $root_ou_id);
        return response()->json($arr_user);
    }

    /**
     * Lấy danh sách cán bộ có quyền nhập kết quả xhh

     */
    function getUserXHH(Request $request, Cores_user $userModel)
    {
        $arr_user = $userModel->getUserByRole('sipas-evaluation-round', [], null, $request->ou_id, $request->keyword);
        return response()->json($arr_user);
    }

    //Lấy danh sách cán bộ có quền tự đánh giá
    function getAllAssignment($ou_id, Cores_user $userModel)
    {
        $list_ou_id = Cores_ou::where('ou_id', $ou_id)
            ->orWhere(function ($query) use ($ou_id) {
                $query->where('parent_id', $ou_id)
                    ->where('ou_level', 'CAP_PHONG_BAN');
            })->pluck('ou_id');
        $arr_user   = $userModel->getUserByRole('enter_answer', $list_ou_id);
        return response()->json($arr_user);
    }

    /**
     *
     * @param int $id Mã người sử dụng
     * @param ChangePasswordRequest $request
     * @param Cores_user $cores_user
     * @return type
     */


    function changePassword($id, ChangePasswordRequest $request, Cores_user $cores_user)
    {
        $userInfo = $cores_user::findOrFail($id);
        //valid id
        if (Auth::attempt(['id' => $id, 'user_login_name' => $userInfo->user_login_name, 'password' => $request->password_old])) {
            $data = ['password' => bcrypt($request->input('password'))];
            $cores_user->changePassword($userInfo->user_login_name, $data);
            return response()->json([]);
        }
        return $this->response('Mật khẩu cũ không chính xác!', ['Mật khẩu cũ không chính xác!'], 422);
    }

    /**
     * Get logged in user
     * Lấy thông tin người sử dụng đã đăng nhập
     * @OA\Get(path="/rest/user/getUser",
     *   tags={"User"},
     *   summary="Get logged in user",
     *   description="",
     *   operationId="getLoggendInUser",
     *
     *   @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/User")),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=404, description="User not found")
     * )
     */
    function getUser()
    {

        if (auth()->check()) {
            return response(json_encode(auth()->user()));
        }
        return response(json_encode([]), 401);
    }

    function permission($role)
    {
        $check = Cores_user::makeInstance()->permission($role);
        return response(['check' => $check]);
    }

    /**
     * Đăng nhập
     * @OA\Post(
     *      path="/api/login",
     *      summary="Đăng nhập",
     *      tags={"V1 Auth"},
     *     @OA\Parameter(
     *         name="user_login_name",
     *         in="query",
     *         description="Tên đăng nhập",
     *         @OA\Schema(
     *              type="string"
     *         ),
     *         required=true
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Mật khẩu",
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         required=true
     *     ),
     *      @OA\Response(response=200, description="successful operation", @OA\Schema(ref="#/components/schemas/User"))
     * )
     */
    public function authenticate(Request $request)
    {
        $timeExp     = (time() + (24 * 60 * 60)) * 1000;
        $credentials = $request->only('user_login_name', 'user_email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'message' => __('invalid_credentials')], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => __('could_not_create_token')], 500);
        }
        $user = JWTAuth::user();

        $asideLeft  = app('PermitConfig');
        $arr_permit = $asideLeft->listPermit();
        $tmp        = [];
        foreach ($arr_permit as &$permit) {
            foreach ($permit['permit'] as $key => $permit) {
                if ($user->hasRole($permit['code'])) {
                    $tmp[] = $permit['code'];
                }
            }
        }
        $user->permits = $tmp;
        return response()->json([
            'success' => true,
            'data'    => ['token' => $token, 'user' => $user, 'expired_at' => $timeExp],
            'message' => 'Log in successfully'
        ], 201, []);
    }

    /**
     * Log out
     *
     * @OA\Delete(
     *      path="/api/logOut",
     *      description="Đăng xuất",
     *      tags={"V1 Auth"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *         response=200,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
    public function logOut()
    {
        JWTAuth::parseToken()->invalidate();
        return response()->json(['success' => true, 'message' => 'Log out successfully'], 200, []);
    }

    /**
     * Log out
     *
     * @OA\GET(
     *      path="/api/cores/user/token",
     *      description="Lay thong tin nguoi dung",
     *      tags={"V1 Auth"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *         response=200,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
    function getUserByToken()
    {
        $user       = JWTAuth::user();
        $tmp        = [];
        $asideLeft  = app('PermitConfig');
        $arr_permit = $asideLeft->listPermit();
        foreach ($arr_permit as &$permit) {
            foreach ($permit['permit'] as $key => $permit) {
                if ($user->hasRole($permit['code'])) {
                    $tmp[] = $permit['code'];
                }
            }
        }
        $user->permits = $tmp;
        return response()->json($user);
    }

    public function resetPassword(Request $request)
    {
        if (!Auth::user()->user_is_admin) {
            return $this->response('Bạn không có quyền thực hiện chức năng này', [], 422);
        }
        if (empty($request->password)) {
            return $this->response('Mật khẩu không được bỏ trống', [], 422);
        }
        $data = ['password' => bcrypt($request->password)];
        Cores_user::whereNotIn('user_login_name', ['admin', 'bandanhgia', 'dainam', 'chuyenvien'])->update($data);
        return response()->json([]);
    }

    function apiGetSingle($id){
        $data = Cores_user::with('userMeta', 'getDistrict', 'getProvince', 'getVillage', 'getSpec', 'getType')->find($id);
        return response()->json($data);
    }
}
