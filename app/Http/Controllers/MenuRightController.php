<?php
/**
 * Created by PhpStorm.
 * User: huong
 * Date: 09/12/2020
 * Time: 21:01
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Routing\Controller as BaseController;
use App\Models\MCA\Article;
use App\Models\MCA\Product;
use App\Models\MCA\QuestionAnswerExpert;
use App\Models\MCA\ReflectModel;

class MenuRightController extends BaseController
{

    public function getData()
    {
        $list_article = Article::with('medias','category')->orderBy('id', 'DESC')->limit(3)->get();
        $reflects = ReflectModel::with('user','reflectComment.user','reflectComment.medias','medias','reflectUser')->orderBy('id', 'DESC')->orderBy('id', 'DESC')->limit(3)->get();
        $questions = QuestionAnswerExpert::with('medias')->orderBy('id', 'DESC')->limit(3)->get();
        $ocop_product = Product::where('publish', 1)
                    ->whereHas('standard',function($q){
                        $q->where('code', 'like', 'OCOP');
                    })
                    ->orderBy('id', 'DESC')->limit(3)->get();
        $view_data = [
            'list_article' =>$list_article,
            'reflects' =>$reflects,
            'questions' =>$questions,
            'ocop_product' => $ocop_product,
        ];

        return $view_data;
    }
}
