<?php

namespace App\Models\Cores;

/**
 *
 * @OA\Schema(
 *     schema="Ou",
 *     title="Ou model",
 *     description="Lưu trữ và quản lý đơn vị hành chính",
 * )
 */

use App\Models\MCA\SpecModal;
use App\Models\MCA\TypeModel;
use App\Models\EnterpriseGroupTypeModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Models\Cores\Cores_ou_meta;
use App\Models\ManageWorkerModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Auth;

class Cores_ou extends Model
{
    /**
     * @OA\Property(
     *     property="ou_id",
     *     description="ID đơn vị",
     * )
     * @var integer
     */
    /**
     * @OA\Property(
     *     property="ou_name",
     *     description="Tên đơn vị",
     * )
     * @var string
     */
    /**
     * @OA\Property(
     *     property="parent_id",
     *     description="ID Đơn vị cha",
     * )
     * @var integer
     */
    /**
     * @OA\Property(
     *     property="ou_level",
     *     description="Cấp đơn vị",
     * )
     * @var string
     */
    /**
     * @OA\Property(
     *     property="ou_order",
     *     description="Thứ tự hiển thị",
     * )
     * @var string
     */
    /**
     * @OA\Property(
     *     property="ou_status",
     *     description="Trạng thái",
     * )
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="depth",
     *     description="Thứ tự theo cấp",
     * )
     * @var string
     */
    protected $primaryKey = 'ou_id';
    public $timestamps = FALSE;
    protected $table = 'cores_ous';

    const _CONST_CAP_SO = 'CAP_SO'; // cấp sở
    const _CONST_CAP_TINH = 'CAP_TINH'; // cấp tỉnh
    const _CONST_CAP_HUYEN = 'CAP_HUYEN'; // Cấp huyện
    const _CONST_CAP_PHONG_BAN = 'CAP_PHONG_BAN'; // Cấp phòng ban
    const _CONST_CAP_XA = 'CAP_XA'; // Cấp xã
    const _CONST_STATUS_DANG_HOAT_DONG = 1; //đang hoạt động
    const _CONST_STATUS_KHONG_HOAT_DONG = 0; // ngừng hoạt động
    const _CONST_STATUS_DANG_HOAT_DONG_KHONG_DOANH_THU = 2; // đang hoạt động không phát sinh doanh thu
    const _CONST_STATUS_DUNG_HOAT_DONG_CHO_GIAI_THE = 3; // Dừng hoạt dộng chờ giải thể
    const _CONST_STATUS_GIAI_THE = 4; //giải thể

    function get_ou_level()
    {
        return [
            self::_CONST_CAP_SO,
            self::_CONST_CAP_TINH,
            self::_CONST_CAP_HUYEN,
            self::_CONST_CAP_PHONG_BAN,
            self::_CONST_CAP_XA,
        ];
    }

    function get_ou_status()
    {
        return [
            self::_CONST_STATUS_DANG_HOAT_DONG => 'Đang hoạt động',
            self::_CONST_STATUS_KHONG_HOAT_DONG => 'Ngừng hoạt động',
            self::_CONST_STATUS_DANG_HOAT_DONG_KHONG_DOANH_THU => 'Hoạt động không phát sinh doanh thu',
            self::_CONST_STATUS_DUNG_HOAT_DONG_CHO_GIAI_THE => 'Dừng hoạt đồng chờ giải thể',
            self::_CONST_STATUS_GIAI_THE => 'Giải thể/phá sản',
        ];
    }

    public static function makeInstance()
    {
        return new self();
    }

    public function users()
    {
        return $this->hasMany(Cores_user::class, 'ou_id', 'ou_id');
    }

    public function manageWorker(){
        return $this->hasMany(ManageWorkerModel::class,'ou_id','ou_id');
    }

    public function ouMeta(){
        return $this->hasMany(Cores_ou_meta::class,'ou_id','ou_id');
    }

    public function product(){
        return $this->hasMany(ProductModel::class,'ou_id','ou_id');
    }

    public function provinceInfo()
    {
        return $this->belongsTo(Cores_province::class, 'province_id', 'id');
    }

    public function districtInfo()
    {
        return $this->belongsTo(Cores_district::class, 'district_id', 'id');
    }

    public function villageInfo()
    {
        return $this->belongsTo(Cores_village::class, 'village_id', 'id');
    }

    public function careerInfo()
    {
        return $this->belongsTo(SpecModal::class, 'career_id', 'id');
    }

    public function enterpriseTypeInfo()
    {
        return $this->belongsTo(TypeModel::class, 'enterprise_type_id', 'id');
    }

    function scopeFillterKeyword($query, $keyword)
    {
        if (trim($keyword) !== '') {
            return $query->where(function ($sql) use ($keyword) {
                $sql->where('ou_name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('fax', 'like', "%$keyword%")
                    ->orWhere('phone', 'like', "%$keyword%")
                    ->orWhere('tax_code', 'like', "%$keyword%");
            });
        }
        return $query;
    }

    function scopeFillterRank($query, $rank)
    {
        if (empty($rank)) {
            return $query;
        }
        if ($rank == -1) {
            return $query->whereNull('rank');
        }
        return $query->where('rank', $rank);
    }

    function scopeFillterVerify($query, $verify)
    {
        if(is_null($verify)) {
            return $query;
        }
        return $query->where('verify', $verify);
    }

    function scopeFillterProvince($query, $province_id)
    {
        if ($province_id) {
            return $query->where('province_id', $province_id);
        }
        return $query;
    }

    function scopeFillterDistrict($query, $district_id)
    {
        if ($district_id) {
            return $query->where('district_id', $district_id);
        }
        return $query;
    }

    function scopeFillterVillage($query, $village_id)
    {
        if ($village_id) {
            return $query->where('village_id', $village_id);
        }
        return $query;
    }

    function scopeFillterEnterpriseType($query, $enterprise_type_id)
    {
        if ($enterprise_type_id) {
            return $query->where('enterprise_type_id', $enterprise_type_id);
        }
        return $query;
    }

    public function scopeFilterEnterpriseGroup($query,$enterprise_group_id){
        if(isset($enterprise_group_id)){
            $list_type = [];
            $group = EnterpriseGroupTypeModel::find($enterprise_group_id);
            foreach($group->enterpriseTypesInfo as $type){
                array_push($list_type,$type->id);
            }
            $query->whereIn('enterprise_type_id',$list_type);
        };
        return $query;
    }

    function scopeFillterCareer($query, $career_id)
    {
        if ($career_id) {
            return $query->where('career_id', $career_id);
        }
        return $query;
    }

    function scopeFillterLevel($query, $level)
    {
        if ($level) {
            return $query->where('ou_level', $level);
        }
        return $query;
    }

    function scopeFillterStatus($query, $status)
    {
        if ($status !== null && $status !== '') {
            return $query->where('ou_status', $status);
        }
        return $query;
    }

    public function scopeOrderByCol($query, $order_col = null, $direction = 'asc')
    {
        $direction = $direction === 'desc' ? 'desc' : 'asc';
        $arr_col = ['ou_id', 'ou_name'];
        $order_col = in_array($order_col, $arr_col) ? $order_col : '';
        if (!empty($order_col)) {
            return $query->orderBy($order_col, $direction);
        }
        return $query->orderBy('ou_id', $direction);
    }

    public function scopeGetOrPaginate($query, $limit)
    {
        if ((int)$limit < 1) {
            return $query->get();
        }
        return $query->paginate($limit);
    }

    /**
     * Thêm mới đơn vị/Phòng ban
     * @param string $v_ou_name
     * @param string $v_ou_level
     * @param int $v_ou_order
     * @param int $parent_id
     * @return type
     */
    function addNew($v_ou_name, $v_ou_level, $v_ou_order, $parent_id, $latitude = '', $longitude = '', $radius = 0)
    {
        $parent_id = (int)$parent_id;
        $v_ou_id = $this->insertGetId(
            [
                'ou_name' => $v_ou_name,
                'ou_level' => $v_ou_level,
                'ou_order' => $v_ou_order,
                'parent_id' => $parent_id,
                'parent_id' => $parent_id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'radius' => (float)$radius,
                'ou_status' => 1,
            ]
        );
        $this->_reorder($v_ou_id, $parent_id, $v_ou_order);
        return $v_ou_id;
    }

    /**
     *
     */
    function destroyOu($id)
    {

        $ouInfo = $this->find($id);

        if (!is_null($ouInfo)) {
            $this->_delete_child($ouInfo);
            //Xoa mapping user
            $this->_delete_ou_mapp_user($id);
            //Xoa ou dang chon
            $ouInfo->delete();
        }
    }

    /**
     * Xóa các thằng con
     * @param type $ouInfo
     */
    private function _delete_child($ouInfo)
    {
        $arrChild = $this->where('parent_id', $ouInfo->ou_id)->get();
        if (!is_null($arrChild)) {
            foreach ($arrChild as $child) {
                $this->_delete_child($child);
                $this->_delete_ou_mapp_user($child->ou_id);
                $this->find($child->ou_id)->delete();
            }
        }
    }

    private function _delete_ou_mapp_user($v_ou_id)
    {
        Cores_user_meta::where([
            ['user_meta_key', Cores_user_meta::_CONST_OU_PARENT],
            ['user_meta_value', $v_ou_id],
        ])->delete();
    }

    /**
     * Update ou
     * @param int $v_ou_id
     * @param type $v_ou_name
     * @param type $v_ou_level
     * @param type $v_ou_order
     * @param type $parent_id
     */
    function edit($v_ou_id, $v_ou_name, $v_ou_level, $v_ou_order, $parent_id, $latitude = '', $longitude = '', $radius = 0)
    {
        $ouInfo = $this->find($v_ou_id);
        if (is_null($ouInfo)) {
            throw new Exception('Mã đơn vị không hợp lệ');
        }
        $this->where('ou_id', $v_ou_id)->update([
            'ou_name' => $v_ou_name,
            'ou_level' => $v_ou_level,
            'ou_order' => (int)$v_ou_order,
            'parent_id' => (int)$parent_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'radius' => (float)$radius,
            'ou_status' => 1,
        ]);
        $this->_reorder($v_ou_id, (int)$parent_id, (int)$v_ou_order);
    }

    /**
     * Lấy thông tin chi tiết đơn vị
     * @param type $ou_id
     * @return type
     */
    function getInfo($ou_id)
    {
        return $this->find($ou_id);
    }

    /**
     * Lấy thông tin chi tiết đơn vị
     * @param type $ou_id
     * @return type
     */
    function getMaxOrder()
    {
        return $this->max('ou_order');
    }

    /**
     * Lấy danh sách Đơn vị/phòng ban
     * @return type
     */
    function getAll($params)
    {
        $v_keyword = $params['keyword'] ?? '';
        $v_rank = $params['rank'] ?? '';
        $v_verify = $params['verify'] ?? null;
        $v_province_id = $params['province_id'] ?? '';
        $v_district_id = $params['district_id'] ?? '';
        $v_village_id = $params['village_id'] ?? '';
        $v_enterprise_type_id = $params['enterprise_type_id'] ?? '';
        $v_career_id = $params['career_id'] ?? '';
        $v_ou_level = $params['ou_level'] ?? '';
        $v_ou_status = $params['ou_status'] ?? '';
        $v_order_col = $params['order_col'] ?? 'ou_name';
        $v_direction = $params['direction'] ?? 'asc';
        $v_limit = $params['limit'] ?? 0;

        return $this::with('provinceInfo', 'districtInfo', 'villageInfo', 'careerInfo', 'enterpriseTypeInfo')
            ->fillterKeyword($v_keyword)
            ->fillterRank($v_rank)
            ->fillterVerify($v_verify)
            ->fillterProvince($v_province_id)
            ->fillterDistrict($v_district_id)
            ->fillterVillage($v_village_id)
            ->fillterEnterpriseType($v_enterprise_type_id)
            ->fillterCareer($v_career_id)
            ->fillterLevel($v_ou_level)
            ->fillterStatus($v_ou_status)
            ->orderByCol($v_order_col, $v_direction)
            ->getOrPaginate($v_limit);
    }

    function getAllReceivedNotificationOu($v_ou_level = NULL)
    {
        $instance = $this;

        if (!is_null($v_ou_level)) {
            $ous = $instance->where('parent_id', Auth::user()->root_ou_id)->where('ou_level', $v_ou_level)->orderBy('depth', 'asc')->get();
        } else {
            $ous = $instance->where('parent_id', Auth::user()->root_ou_id)->orderBy('depth', 'asc')->get();
        }

        return $ous;
    }

    function getAllNested()
    {
        //Nếu dung thuoc don vi cap huyen, so
        if (Auth::user()->root_ou_id) {
            $ous = $this->where('ou_id', Auth::user()->root_ou_id)->where('ou_level', Cores_ou::_CONST_CAP_PHONG_BAN)->orderBy('ou_order')->get();
        } else {

            $ous = $this->where('parent_id', 0)->where('ou_level', Cores_ou::_CONST_CAP_PHONG_BAN)->orderBy('ou_order')->get();
        }
        foreach ($ous as &$ou) {
            $ou->child = $this->where('parent_id', $ou->ou_id)->orderBy('ou_order')->get();
        }
        return $ous;
    }

    /**
     * Lấy danh sách Đơn vị/phòng ban
     * @return type
     */
    function getAllOuForEvaluationRound($v_ou_level = NULL)
    {

        $instance = $this;

        if (!is_null($v_ou_level)) {
            $root_ou_id = Auth::user()->root_ou_id;
            //Nếu là đơn vị cập huyện thì lấy danh sách xã của huyện đó huyện đó
            if ($root_ou_id) {
                $instance = $instance->where('parent_id', Auth::user()->root_ou_id);
            }
            $ous = $instance->where('ou_level', $v_ou_level)->orderBy('parent_id', 'asc')->orderBy('depth', 'asc')->get();
        } else {
            $ous = $instance->orderBy('depth', 'asc')->get();
        }

        return $ous;
    }

    function getAllOuAndUser($id_parent = 0)
    {
        $data = array();
        //Neu thuoc don vi con
        if (Auth::user()->root_ou_id && $id_parent == 0) {
            $data['ous'] = $this->where('ou_level', Cores_ou::_CONST_CAP_PHONG_BAN)
                ->where('ou_id', Auth::user()->root_ou_id)->orderBy('ou_order')->get();
        } elseif (Auth::user()->root_ou_id && $id_parent != Auth::user()->root_ou_id) {
            $data['ous'] = [];
        } else {
            $data['ous'] = $this->where('ou_level', Cores_ou::_CONST_CAP_PHONG_BAN)
                ->where('parent_id', $id_parent)->orderBy('ou_order', 'asc')->get();
        }
        $instance = Cores_user::where('ou_id', $id_parent);
        if (!config('app.APP_DEBUG')) {
            $instance->where('user_login_name', '<>', 'dainam');
        }
        $data['users'] = $instance->orderBy('user_order', 'asc')->get();

        return $data;
    }

    function getAllOuAndOuSurvey($ou_id = 0, $ou_survey_id = null)
    {
        $data = array();
        if (empty($ou_survey_id)) {
            $data['ous'] = $this->where('parent_id', $ou_id)->orderBy('ou_order', 'asc')->get();
            $data['ouSurvey'] = Cores_ou_survey::where('ou_id', $ou_id)->orderBy('order', 'asc')->get();
        } else {
            $data['ous'] = [];
            $data['ouSurvey'] = Cores_ou_survey::where([
                ['parent_id', $ou_survey_id],
            ])->orderBy('order', 'asc')->get();
        }

        return $data;
    }

    /**
     * Thuc hien order
     * @param type $id
     * @param type $parent
     * @param type $order
     */
    private function _reorder($id, $parent, $order)
    {
        //Lấy danh sách cần sắp xép lại
        $arrOu = Cores_ou::where('parent_id', $parent)
            ->where('ou_id', '<>', $id)
            ->orderBy('ou_order')->get();

        $order = (int)$order > 0 ? (int)$order : count($arrOu) + 1;
        //Cập nhật thứ tự của nó
        $detailInfo = Cores_ou::find($id);
        $depth = '/' . $this->_build_order_depth($order);
        if ((int)$parent > 0) {
            $parentOuInfo = Cores_ou::find($parent);
            $depth = $parentOuInfo->depth . $depth;
        }
        //CẬp nhật thứ tự mới
        $detailInfo->ou_order = $order;
        $detailInfo->depth = trim($depth, '/');
        $detailInfo->save();
        if (Cores_ou::where('parent_id', $detailInfo->ou_id)->count() > 0) {
            $this->_reorderChild($detailInfo->ou_id, $detailInfo->depth);
        }


        //THỨ tự mới
        $orderNew = 1;
        if (is_null($arrOu)) {
            return true;
        }
        //CẬp nhật thứ tự mới
        foreach ($arrOu as $val) {
            if ($order == $orderNew) {
                $orderNew += 1;
            }
            $depth = '/' . $this->_build_order_depth($orderNew);
            if ((int)$parent > 0) {
                $parentOuInfo = Cores_ou::find($parent);
                $depth = $parentOuInfo->depth . $depth;
            }
            //CẬp nhật thứ tự anh em mới
            $val->depth = trim($depth, '/');
            $val->ou_order = $orderNew;
            $val->save();
            if (Cores_ou::where('parent_id', $val->ou_id)->count() > 0) {
                $this->_reorderChild($val->ou_id, $val->depth);
            }
            $orderNew += 1;
        }
    }

    /**
     * Sap xep lai cac thang con
     * @param int $parent_id Ma doi tuong cha
     * @param string $depth
     */
    private function _reorderChild($parent_id, $depth)
    {
        if (intval($parent_id) > 0) {
            $listOuOrder = Cores_ou::where('parent_id', $parent_id)->orderBy('ou_order')->get();
            for ($i = 0; $i < count($listOuOrder); $i++) {
                $listOuOrder[$i]->ou_order = $i + 1;
                $listOuOrder[$i]->depth = trim($depth, '/') . '/' . $this->_build_order_depth($listOuOrder[$i]->ou_order);
                $listOuOrder[$i]->save();
                if (Cores_ou::where('parent_id', $listOuOrder[$i]->ou_id)->count() > 0) {
                    $this->_reorderChild($listOuOrder[$i]->ou_id, $listOuOrder[$i]->depth);
                }
            }
        }
    }

    /**
     *
     * @param type $order
     */
    private function _build_order_depth($order)
    {
        $depth = $order;
        for ($i = 1; $i < (10 - strlen($order)); $i++) {
            $depth = '0' . $depth;
        }
        return $depth;
    }

    /**
     * Lấy đơn vị trươc thuộc(Không tính phòng ban)
     * @param type $ou_id
     * @return string
     */
    function get_subordinate_units($ou_id)
    {
        $ou_info = Cores_ou::find($ou_id);
        if ($ou_info->ou_level == Cores_ou::_CONST_CAP_PHONG_BAN) {
            $ou_info = Cores_ou::find($ou_info->parent_id);
        }
        return $ou_info;
    }

    function insertEnterprise($params){
        $v_ou_id = $this->insertGetId($params);
    }

    /**
     * Load user info from meta
     * @param object
     */
    function load_other(&$singleInfo)
    {
        $other_info = [];
        $other  = Cores_ou_meta::where('ou_id', $singleInfo->ou_id)->get();
        foreach ($other as $otherInfo) {
            $other_info[$otherInfo->ou_meta_key] = $otherInfo->ou_meta_value;
        }
        $singleInfo->other_info = $other_info;
    }

}
