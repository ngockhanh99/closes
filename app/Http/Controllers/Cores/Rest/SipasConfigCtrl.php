<?php

namespace App\Http\Controllers\Cores\Rest;

use \App\Http\Controllers\RestController;
use App\Models\RoundModel;
use App\Models\SipasConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SipasConfigCtrl extends RestController
{

    /**
     * Permit
     * @var type
     */
    private $permit;

    public function __construct()
    {
        $this->permit = app('PermitConfig');
    }

    function getAllTypeSipasReport()
    {
        $permits = $this->permit->listPermit();
        $arr_permit = array();
        foreach ($permits as $permit) {
            foreach ($permit['permit'] as $value) {
                if ($value['allowed_config'] == 1) {
                    $arr_permit[] = $value;
                }
            }
        }
        return response()->json($arr_permit);

    }

    function getAll()
    {
        $arr_round = RoundModel::leftJoin('t_round_ou', 't_round_ou.round_id', 't_round.id')
            ->where([
                ['t_round.published', 1],
                ['t_round.ou_id', Auth::user()->root_ou_id]
            ])
            ->groupBy('t_round.id')
            ->orderBy('t_round.id')
            ->select('t_round.*')
            ->get();
        return $arr_round;
    }

    function update(Request $request)
    {
        $count = SipasConfigModel::where([
            ['round_id', $request->round_id],
            ['type_report', $request->type_report]
        ])->count();
        if ($count) {
            SipasConfigModel::where([
                ['round_id', $request->round_id],
                ['type_report', $request->type_report]
            ])->update(['config' => json_encode($request->config)]);
        } else {
            SipasConfigModel::insert(array('round_id' => $request->round_id, 'type_report' => $request->type_report, 'config' => json_encode($request->config)));
        }
    }

    function getDetailConfig(Request $request)
    {
        $config = SipasConfigModel::where([
            ['round_id', $request->round_id],
            ['type_report', $request->type_report]
        ])->first()['config'];
        return $config;
    }

}
