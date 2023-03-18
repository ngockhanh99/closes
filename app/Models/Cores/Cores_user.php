<?php
/**
 * @license Apache 2.0
 */

namespace App\Models\Cores;

/**
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User model",
 *     description="Lưu trữ và quản lý người sử dụng",
 * )
 */

use Illuminate\Database\Eloquent\Model;
use App\Models\Cores\Cores_user_meta;
use App\Models\Cores\Cores_province;
use App\Models\Cores\Cores_district;
use App\Models\Cores\Cores_village;
use App\Models\MCA\SpecModel;
use App\Models\MCA\TypeModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Models\MCA\Product;

class Cores_user extends Model
{
    use Notifiable;

    /**
     * @OA\Property(
     *     property="id",
     *     description="ID người sử dụng",
     * )
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="user_name",
     *     description="Tên người sử dụng",
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="user_login_name",
     *     description="Tên đăng nhập NSD",
     * )
     * @var string
     */

    /**
     * @OA\Property(
     *     property="user_email",
     *     description="Địa chỉ Email NSD",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="user_is_admin",
     *     description="Người dùng có phải là quản trị viên hay không",
     * )
     *
     * @var boolean
     */

    /**
     * @OA\Property(
     *     property="user_order",
     *     description="Thứ tự hiển thị",
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="user_status",
     *     description="Trạng thái",
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="user_avatar",
     *     description="Ảnh đại diện",
     * )
     *
     * @var string
     */

    const LIST_ROLE = [
        "SAN_XUAT" => "Sản xuất",
        "THUONG_MAI" => "Thương mại",
        "TU_VAN" => "Tư vấn",
        "CUNG_CAP" => "Đơn vị cung cấp",
//        "NHA_NUOC" => "Nhà nước",
    ];

    const STATUS_ACTIVE = 1;
    const USER_VERIFIED = true;

    protected $primaryKey = 'id';
    public    $timestamps = FALSE;
    protected $table      = 'users';
    protected $hidden     = [
        'password', 'remember_token',
    ];
    protected $fillable = [
        'user_name',
        'user_login_name',
        'root_ou_id',
        'ou_id',
        'user_email',
        'user_phone',
        'password',
        'user_is_admin',
        'user_order',
        'user_status',
        'verified',
        'user_avatar',
        'user_role',
        'type_id',
        'spec_id',
        'province_id',
        'district_id',
        'village_id',
        'remember_token',
    ];

    static function makeInstance()
    {
        return new self();
    }

    public function userMeta(){
        return $this->hasMany(Cores_user_meta::class,'user_id');
    }
    public function products(){
        return $this->hasMany(Product::class,'user_id');
    }
    public function getDistrict(){
        return $this->belongsTo(Cores_district::class,'district_id')->select('id','name');
    }
    public function getProvince(){
        return $this->belongsTo(Cores_province::class,'province_id')->select('id','name');
    }
    public function getVillage(){
        return $this->belongsTo(Cores_village::class,'village_id')->select('id','name');
    }
    public function getSpec(){
        return $this->belongsTo(SpecModel::class,'spec_id')->select('id','name');
    }
    public function getType(){
        return $this->belongsTo(TypeModel::class,'type_id')->select('id','name');
    }
    public function scopeFilterByKeyWord($query,$key_word){
        if(trim($key_word) != ''){
            return $query->where('user_name','like',"%{$key_word}%");
        }
        return $query;
    }
    public function scopeFilterByRole($query,$role){
        if(trim($role) != ''){
            return $query->where('user_role','like',"%{$role}%");
        }
        return $query;
    }
    public function scopeFilterByAddress($query,$address){
        if(trim($address) != ''){
            return $query->whereHas('userMeta',function($q) use($address){
                $q->where('user_meta_value','like',"%{$address}%");
            });
        }
        return $query;
    }
    public function scopeFilterBySpec($query,$spec_id){
        if(trim($spec_id) != ''){
            return $query->where('spec_id',$spec_id);
        }
        return $query;
    }
    public function scopeFilterByType($query,$type_id){
        if(trim($type_id) != ''){
            return $query->where('type_id',$type_id);
        }
        return $query;
    }
    public function scopeGetOrPaginate($query,$limit){
        if ((int)$limit < 1) {
            return $query->get();
        }
        return $query->paginate($limit);
    }
    function insertUser(array $userInfo = [], array $userOther = [], array $arrGroupChosen = [], array $arrOuChosen = [], array $arrPermitChosen = [])
    {
        $is_admin  = Auth::user() && Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $v_user_id = 0;
        $userMeta  = new Cores_user_meta();
        try {
            $userInfo['password']      = bcrypt($userInfo['password']);
            $userInfo['user_status']   = boolval($userInfo['user_status']);
            $userInfo['user_is_admin'] = boolval($userInfo['user_is_admin']);
            $userInfo['user_order']    = intval($userInfo['user_order']);
            $v_user_id                 = $this->insertGetId($userInfo);

            //update info
            $userMeta->updateUserInfo($v_user_id, $userOther);
            //update ou parent
            if ($arrOuChosen == [] && !$is_admin) {
//                $v_user_loggedIn = Auth::user()->id;
//                $user_ou         = Cores_user_meta::where([['user_id', $v_user_loggedIn], ['user_meta_key', Cores_user_meta::_CONST_OU_PARENT]])->pluck('user_meta_value')->toArray();

                if (!empty($user_ou)) {
                    $arrOuChosen = [intval($user_ou[0])];
                }
            }
            $userMeta->updateByMetaKey($v_user_id, $arrOuChosen, Cores_user_meta::_CONST_OU_PARENT);
            #Insert permit
            $userMeta->updateByMetaKey($v_user_id, $arrPermitChosen, Cores_user_meta::_CONST_PERMIT);
            #Insert group
            $userMeta->updateByMetaKey($v_user_id, $arrGroupChosen, Cores_user_meta::_CONST_GROUP_PARENT);

            $this->_reorder($v_user_id, $userInfo['ou_id'], $userInfo['user_order']);
        } catch (Exception $ex) {
            //Rollback
            $this->where('id', $v_user_id)->delete();
            Cores_user_meta::where('user_id', $v_user_id)->delete();
        }
        return $v_user_id;
    }

    function edit(array $userInfo = [], array $userOther = [], array $arrGroupChosen = [], array $arrOuChosen = [], array $arrPermitChosen = [])
    {
        $userMeta = new Cores_user_meta();
        try {
            $v_user_id = $userInfo['id'];
            if (trim($userInfo['password']) != '') {
                $userInfo['password'] = bcrypt($userInfo['password']);
            } else {
                unset($userInfo['password']);
            }
            $userInfo['user_status'] = boolval($userInfo['user_status']);
            if (!is_null($userInfo['user_is_admin'])) {
                $userInfo['user_is_admin'] = boolval($userInfo['user_is_admin']);
            } else {
                unset($userInfo['user_is_admin']);
            }
            $userInfo['user_order'] = intval($userInfo['user_order']);
            $this->where('id', $v_user_id)->update($userInfo);

            //update info
            $userMeta->updateUserInfo($v_user_id, $userOther);
            //update ou parent
            $userMeta->updateByMetaKey($v_user_id, $arrOuChosen, Cores_user_meta::_CONST_OU_PARENT);
            #Insert permit
            $userMeta->updateByMetaKey($v_user_id, $arrPermitChosen, Cores_user_meta::_CONST_PERMIT);
            #Insert group
            $userMeta->updateByMetaKey($v_user_id, $arrGroupChosen, Cores_user_meta::_CONST_GROUP_PARENT);

            $this->_reorder($v_user_id, $userInfo['ou_id'], $userInfo['user_order']);
        } catch (Exception $ex) {
            //Rollback
            $this->where('id', $v_user_id)->delete();
            Cores_user_meta::where('user_id', $v_user_id)->delete();
        }
        return $v_user_id;
    }

    /**
     * Lấy danh sách người sử dụng theo quyền cần xét
     */
    public function getFullUserPermit($v_permit)
    {
        //Lấy danh sách nhóm có quyền
        $groups_id = Cores_group_meta::where([
            ['group_meta_key', Cores_group_meta::_CONST_PERMIT],
            ['group_meta_value', $v_permit],
        ])->pluck('group_id');
        return Cores_user_meta::where(function ($query) use ($groups_id) {
            $query->whereIn('user_meta_value', $groups_id)
                ->where('user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT);
        })->orWhere(function ($query) use ($v_permit) {
            $query->where('user_meta_value', $v_permit)
                ->where('user_meta_key', Cores_user_meta::_CONST_PERMIT);
        })->distinct('user_id')->pluck('user_id');
    }

    /**
     *
     * @param type $v_user_id
     * @return type
     */
    function getSingle($v_user_id)
    {
        $userInfo = Cores_user::find($v_user_id);
        if (is_null($userInfo)) {
            return [];
        }
        $this->_load_other($userInfo);
        return $userInfo->toArray();
    }

    /**
     * Lay danh sach nguoi su dung
     * @param int $v_limit
     * @param null $v_ou_id
     * @param string $v_permit
     * @param bool $full_option
     * @return array
     */
    public function getAll($v_limit = 25, $v_ou_id = null, $v_permit = '', $v_keywords = '', $full_option = false)
    {
        $is_admin  = Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $v_user_id = Auth::user()->id;
        $instance  = $this;

        if (!$is_admin) {
            $user_ou = Cores_user_meta::where([['user_id', $v_user_id], ['user_meta_key', Cores_user_meta::_CONST_OU_PARENT]])->pluck('user_meta_value')->all();
            if (empty($user_ou)) {
                return [];
            } else {
                $ou_parent = \App\Models\Cores\Cores_ou::where('ou_id', intval($user_ou[0]))->pluck('parent_id')->all();
                $list_ous  = [];
                if (!empty($ou_parent)) {
                    // Nếu đầu mối đơn vị trực thuộc đơn vị gốc
                    if ($ou_parent[0] == 0) {
                        $list_ous = \App\Models\Cores\Cores_ou::where('parent_id', $user_ou[0])->orWhere('ou_id', $user_ou[0])->pluck('ou_id')->all();
                    } else {
                        $list_ous = \App\Models\Cores\Cores_ou::where('parent_id', intval($ou_parent[0]))->orWhere('ou_id', intval($ou_parent[0]))->pluck('ou_id')->all();
                    }
                }
            }

            $user_in_ou = Cores_user_meta::where('user_meta_key', Cores_user_meta::_CONST_OU_PARENT)->whereIn('user_meta_value', $list_ous)->pluck('user_id')->all();
            $instance   = $instance->whereIn('id', $user_in_ou);
        }

        if ($v_keywords !== '' && $v_keywords !== null) {
            $instance = $instance->where(function ($query) use ($v_keywords) {
                $query->where('user_name', 'like', "%$v_keywords%")
                    ->orWhere('user_login_name', 'like', "%$v_keywords%");
            });
        }
        if (!empty($v_permit)) {
            $user_in_permit = $this->getFullUserPermit($v_permit);
            $instance       = $instance->whereIn('id', $user_in_permit);
        }

        if (is_null($v_ou_id)) {
            $allUsers = $instance->orderBy('id', 'desc')->paginate($v_limit);
        } else {
            $arr_user_id = Cores_user_meta::where([
                ['user_meta_key', Cores_user_meta::_CONST_OU_PARENT],
                ['user_meta_value', $v_ou_id],
            ])->pluck('user_id');
            $allUsers    = $instance->whereIn('id', $arr_user_id)->orderBy('id', 'desc')->paginate($v_limit);
        }

        if (is_null($allUsers)) {
            return [];
        }

        foreach ($allUsers as &$userInfo) {
            $this->_load_other($userInfo);
            $this->_get_ou_full($userInfo);
            $this->_permit_user($userInfo);
            $this->_get_groups_name($userInfo);

        }
        return $allUsers->toArray();
    }

    private function _get_ou_full(&$userInfo)
    {
        $ou_full = Cores_ou::where('ou_id', $userInfo->ou_id)->first()->ou_name;
        if ($userInfo->root_ou_id > 0 && $userInfo->root_ou_id != $userInfo->ou_id) {
            $ou_full = $ou_full . ', ' . Cores_ou::where('ou_id', $userInfo->root_ou_id)->first()->ou_name;
        }
        $userInfo->ou_full = $ou_full;
    }

    private function _get_groups_name(&$userInfo)
    {
        $groups_name = Cores_user_meta::leftJoin('cores_groups', 'cores_groups.group_id', 'cores_user_metas.user_meta_value')
                            ->where([
                                ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT],
                                ['user_id', $userInfo->id],
                            ])->pluck('group_name');
        $userInfo->groups_name = $groups_name;
    }

    private function _permit_user(&$userInfo)
    {
        //Lấy danh sách nhóm của người sử dụng
        $groups_id = Cores_user_meta::where([
            ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT],
            ['user_id', $userInfo->id],
        ])->pluck('user_meta_value');
        //lấy danh sách quyền của các nhóm đó
        $permits_group = Cores_group_meta::where([
            ['group_meta_key', Cores_group_meta::_CONST_PERMIT],
        ])->whereIn('group_id', $groups_id)->distinct('group_meta_value')->pluck('group_meta_value')->toArray();
        //lấy danh sách quyền của người sd được phân trực tiếp
        $permits_user  = Cores_user_meta::where([
            ['user_meta_key', Cores_user_meta::_CONST_PERMIT],
            ['user_id', $userInfo->id],
        ])->pluck('user_meta_value')->toArray();
        $permits_group = is_array($permits_group) ? $permits_group : [];
        $permits_user  = is_array($permits_user) ? $permits_user : [];
        $permits       = array_merge($permits_group, $permits_user);
        $permits       = array_unique($permits);
        $permitConfigs = $this->permitConfig->listPermit();
        $permits_name  = [];
        foreach ($permits as $permit) {
            $permit_name = $permit;
            foreach ($permitConfigs as $permitConfig) {
                foreach ($permitConfig['permit'] as $value) {
                    if ($value['code'] === $permit) {
                        $permit_name = $value['label'];
                        break 2;
                    }
                }
            }
            $permits_name[] = $permit_name;
        }
        $userInfo->permits      = $permits;
        $userInfo->permits_name = $permits_name;
    }

    /**
     * Load user info from meta
     * @param object $userInfo
     */
    private function _load_other(&$userInfo)
    {
        $other  = Cores_user_meta::where('user_id', $userInfo->id)->get();
        $permit = [];
        $groups = [];
        $ou     = [];
        foreach ($other as $otherInfo) {
            if ($otherInfo->user_meta_key == Cores_user_meta::_CONST_PERMIT) {
                $permit[] = $otherInfo->user_meta_value;
            } elseif ($otherInfo->user_meta_key == Cores_user_meta::_CONST_GROUP_PARENT) {
                $groups[] = (int)$otherInfo->user_meta_value;
            } elseif ($otherInfo->user_meta_key == Cores_user_meta::_CONST_OU_PARENT) {
                $ou[] = (int)$otherInfo->user_meta_value;
            } else {
                $userInfo->{$otherInfo->user_meta_key} = $otherInfo->user_meta_value;
            }
        }
        $userInfo->permit = $permit;
        $userInfo->groups = $groups;
        $userInfo->ou     = $ou;
    }

    /**
     * Lấy danh sách người sử dụng theo quyền
     * @param $role quyền
     * @param array $list_ou_id
     * @param null $root_ou_id
     * @return array
     */
    function getUserByRole($role, $list_ou_id = [], $root_ou_id = null, $ou_id = null,$keyword = null)
    {
        //Load danh sách nhóm có quyền $role
        $arr_group_id = Cores_group_meta::where([
            ['group_meta_key', Cores_group_meta::_CONST_PERMIT],
            ['group_meta_value', $role],
        ])->pluck('group_id');

        $arr_user_id = Cores_user_meta::where('user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT)
            ->whereIn('user_meta_value', $arr_group_id)
            ->orWhere(function ($sql) use ($role) {
                $sql->where('user_meta_key', Cores_user_meta::_CONST_PERMIT)
                    ->where('user_meta_value', $role);
            })->pluck('user_id')->all();
        if (count($arr_user_id) < 1) {
            return [];
        }


        if (count($list_ou_id) > 0) {

            $arr_user_id = Cores_user::whereIn('id', $arr_user_id)
                ->whereIn('ou_id', $list_ou_id)
                ->pluck('id')->all();
        }

        if (count($arr_user_id) < 1) {
            return [];
        }

        if (!is_null($root_ou_id)) {

            $arr_user_id = Cores_user::whereIn('id', $arr_user_id)
                ->where('root_ou_id', $root_ou_id)
                ->pluck('id')->all();
        }

        if (count($arr_user_id) < 1) {
            return [];
        }

        //load danh sách user có quyền $role
        $instance = $this->whereIn('id', $arr_user_id);
        //lọc theo đơn vị phòng ban
        if(!empty($ou_id)){
            $instance = $instance->where('ou_id', $ou_id);
        }
        if ($keyword !== '' && $keyword !== null) {
            $instance = $instance->where(function ($query) use ($keyword) {
                $query->where('user_name', 'like', "%$keyword%")
                    ->orWhere('user_login_name', 'like', "%$keyword%");
            });
        }
        $users = $instance->get();
        foreach ($users as &$userInfo) {
            $this->_load_other($userInfo);
        }
        return $users;
    }

    function permission($role)
    {
        if (!Auth::check()) {
            return FALSE;
        }
        $v_user_id = auth()->user()->id;
        $hasRole   = Cores_user_meta::where([
            ['user_id', $v_user_id],
            ['user_meta_key', Cores_user_meta::_CONST_PERMIT],
            ['user_meta_value', $role],
        ])->count();
        if ($hasRole > 0)
            return TRUE;

        //Check join group has permission
        $allGroupIdHasRole = Cores_group_meta::where([
            ['group_meta_key', Cores_group_meta::_CONST_PERMIT],
            ['group_meta_value', $role],
        ])
            ->leftJoin('cores_groups', 'cores_groups.group_id', '=', 'cores_group_metas.group_id')
            ->where('cores_groups.group_status', 1)
            ->pluck('cores_groups.group_id');

        $hasRole = Cores_user_meta::where([
            ['user_id', $v_user_id],
            ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT],
        ])
            ->whereIn('user_meta_value', $allGroupIdHasRole)
            ->count();

        if ($hasRole > 0)
            return TRUE;
        return FALSE;
    }

    function changePassword($user_login_name, $userInfo)
    {
        $this->where('user_login_name', $user_login_name)->update($userInfo);
    }


    private function _reorder($id, $ou_id, $order)
    {
        //Lấy danh sách cần sắp xép lại
        $arrUser = $this->where('ou_id', $ou_id)
            ->where('id', '<>', $id)
            ->orderBy('user_order')->get();

        $order = (int)$order > 0 ? (int)$order : count($arrUser) + 1;
        //Cập nhật thứ tự của nó
        $detailInfo = $this->find($id);

        //CẬp nhật thứ tự mới
        $detailInfo->user_order = $order;
        $detailInfo->save();

        //THỨ tự mới
        $orderNew = 1;
        if (is_null($arrUser)) {
            return true;
        }
        //CẬp nhật thứ tự mới
        foreach ($arrUser as $val) {
            if ($order == $orderNew) {
                $orderNew += 1;
            }
            //CẬp nhật thứ tự anh em mới
            $val->user_order = $orderNew;
            $val->save();
            $orderNew += 1;
        }
    }

}