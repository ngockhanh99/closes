<?php
namespace App\classHelpers;

class ReOrder {
    public static function _reorder($object,$other_id=null,$relationship='',$orderName = 'order')
    {
        $id = $object->id;
        $order = $object->order;
        //Lấy danh sách cần sắp xép lại
        $arrData = $object->where('id', '<>', $id);
        if(!empty($relationship) && !empty($other_id)){
            $arrData->where($relationship,$other_id);
        }
        $arrData = $arrData->orderBy($orderName)->get();

        $order = (int)$order > 0 ? (int)$order : count($arrData) + 1;
        $detailInfo = $object->find($id);
        $detailInfo[$orderName] = $order;
        $detailInfo->save();

        //THỨ tự mới
        $orderNew = 1;
        if (is_null($arrData)) {
            return true;
        }
        //CẬp nhật thứ tự mới
        foreach ($arrData as $val) {
            if ($order == $orderNew) {
                $orderNew += 1;
            }
            //CẬp nhật thứ tự anh em mới
            $val[$orderName] = $orderNew;
            $val->save();
            $orderNew += 1;
        }
    }

}
?>