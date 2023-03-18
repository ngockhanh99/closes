<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Models\Cores\CategoryModel;
use App\Models\Cores\Cores_district;
use App\Models\Cores\Cores_province;
use App\Models\Cores\Cores_village;
use App\Models\QuestionFormModel;
use App\Models\RoundModel;
use App\Models\RoundOuFormValueModel;
use App\Models\RoundOuModel;
use App\Models\QuestionModel;
use App\Models\QuestionFormDetailModel;
use App\Models\RoundOuMetaModel;
use App\Models\Cores\Cores_ou;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelCtrl extends RestController
{
    protected $unit_name;

    public function __construct()
    {
        $unit_name = config("app.UNIT_NAME");
        $this->unit_name = mb_strtoupper($unit_name, 'UTF-8');
    }

    public function loadContent(Request $request)
    {
        if (!$request->hasFile('myfile')) {
            return response()->json(['msgErr' => 'Không tài liệu nào được chọn'], 422);
        }

        //Lưu file theo cấu trúc: /năm/ou_{Mã đơn vị}
        $v_year = date('Y');
        $v_mounth = date('m');
        try {
            $path = Storage::disk('public')->putFile("all/$v_year/$v_mounth", $request->file('myfile'));

            $inputFileName = storage_path('app/public') . '/' . $path;

            /** Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = IOFactory::load($inputFileName);

            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $sheetData = $this->removeEmpty($sheetData);
            if ($request->type === 'enterprises') {
                $sheetData = $this->selColumnEnterprises($sheetData);
            }
            if ($request->type === 'manage-worker'){
                $sheetData = $this->selColumnManageWorker($sheetData);
            }
            return response()->json($sheetData);

        } catch (\Exception $ex) {
            return response()->json(['errors' => [], 'message' => $ex->getMessage()], 404);
        }

    }

    private function removeEmpty($sheetData)
    {
        $data = [];
        foreach ($sheetData as $rows) {
            foreach ($rows as $value) {
                if ($value !== null) {
                    $data[] = $rows;
                    break;
                }
            }
        }
        return $data;
    }


    private function selColumnEnterprises($sheetData)
    {
        foreach ($sheetData as $row) {
            $tmp = [];
            $tmp['ou_name'] = isset($row['A']) ? $row['A'] : '';
            $tmp['tax_code'] = isset($row['B']) ? $row['B'] : '';
            $tmp['province_code'] = isset($row['C']) ? $row['C'] : '';
            $tmp['district_code'] = isset($row['D']) ? $row['D'] : '';
            $tmp['village_code'] = isset($row['E']) ? $row['E'] : '';
            $tmp['address'] = isset($row['F']) ? $row['F'] : '';
            $tmp['phone'] = isset($row['G']) ? $row['G'] : '';
            $tmp['fax'] = isset($row['H']) ? $row['H'] : '';
            $tmp['email'] = isset($row['I']) ? $row['I'] : '';
            $tmp['other_info'] = [];
            $tmp['other_info']['director_name'] = isset($row['J']) ? $row['J'] : '';
            $tmp['other_info']['director_phone'] = isset($row['K']) ? $row['K'] : '';
            $tmp['other_info']['director_email'] = isset($row['L']) ? $row['L'] : '';
            $tmp['province_id'] = '';
            $tmp['province_name'] = '';
            $tmp['district_id'] = '';
            $tmp['district_name'] = '';
            $tmp['village_id'] = '';
            $tmp['village_name'] = '';

            $this->getProviderInfo($tmp);
            $this->getDistrictInfo($tmp);
            $this->getVillageInfo($tmp);
            $data[] = $tmp;
        }
        return $data;

    }

    private function selColumnManageWorker($sheetData)
    {
        foreach ($sheetData as $row) {
            $tmp = [];
            $tmp['name'] = isset($row['A']) ? $row['A'] : '';
            $tmp['gender'] = isset($row['B']) ? $row['B'] : '';
            $tmp['birth'] = isset($row['C']) ? $row['C'] : '';
            $tmp['phone'] = isset($row['D']) ? $row['D'] : '';
            $tmp['email'] = isset($row['E']) ? $row['E'] : '';
            $tmp['id_card'] = isset($row['F']) ? $row['F'] : '';
            $tmp['date_of_issue'] = isset($row['G']) ? $row['G'] : '';
            $tmp['place_of_issue'] = isset($row['H']) ? $row['H'] : '';
            $tmp['native_place'] = isset($row['I']) ? $row['I'] : '';
            $tmp['work_place'] = isset($row['J']) ? $row['J'] : '';
            $tmp['date_start'] = isset($row['K']) ? $row['K'] : '';
            $tmp['date_end'] = isset($row['L']) ? $row['L'] : '';
            $tmp['status'] = isset($row['M']) ? $row['M'] : '';

            $data[] = $tmp;
        }
        return $data;
    }

    /**
     * Lấy id quận/huyện theo mã quận/huyện
     * @param $code
     * @return string
     */
    private function getProviderInfo(&$tmp)
    {
        $code = $tmp['province_code'];
        if (empty($code)) {
            return;
        }
        $singleInfo = Cores_province::where('code', $code)->first();
        if (is_null($singleInfo)) {
            return;
        }
        $tmp['province_id'] = $singleInfo->id;
        $tmp['province_name'] = $singleInfo->name;
        return;
    }

    private function getDistrictInfo(&$tmp)
    {
        $code = $tmp['district_code'];
        if (empty($code)) {
            return;
        }
        $singleInfo = Cores_district::where([
            ['province_id', $tmp['province_id']],
            ['code', $code],
        ])->first();
        if (is_null($singleInfo)) {
            return;
        }
        $tmp['district_id'] = $singleInfo->id;
        $tmp['district_name'] = $singleInfo->name;
        return;
    }

    private function getVillageInfo(&$tmp)
    {
        $code = $tmp['village_code'];
        if (empty($code)) {
            return;
        }
        $singleInfo = Cores_village::where([
            ['district_id', $tmp['district_id']],
            ['code', $code],
        ])->first();
        if (is_null($singleInfo)) {
            return;
        }
        $tmp['village_id'] = $singleInfo->id;
        $tmp['village_name'] = $singleInfo->name;
        return;
    }

}
