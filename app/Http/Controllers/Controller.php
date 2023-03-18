<?php

namespace App\Http\Controllers;
/**
 * @OA\Info(title="MCA API", version="1.1")
 * @OA\SecurityScheme(
 *     type="http",
 *     in="header",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public function index()
    {
        $footerInfo = json_encode([]);
        $pageInfo   = json_encode([]);
        return view('cores.index', ['footerInfo' => $footerInfo, 'pageInfo' => $pageInfo]);
    }

    public function questionFormKiosk()
    {
        return view('cores.questionFormKiosk');
    }
    public function sipasOnline()
    {
        return view('cores.sipasOnline');
    }

    public function privacyPolicy()
    {
        return view('cores.privacyPolicy');
    }
}
