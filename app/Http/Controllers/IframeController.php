<?php

namespace App\Http\Controllers;

use App\Models\MCA\Article;
use App\Models\MCA\Category;
use App\Models\MCA\ImportProduct;
use App\Models\MCA\Product;
use App\Models\MCA\QuestionAnswerExpert;
use App\Models\MCA\ReflectModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IframeController extends BaseController
{

    public function report()
    {
        return view('cores.iframe.report');
    }
}
