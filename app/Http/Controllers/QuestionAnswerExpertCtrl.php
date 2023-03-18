<?php

namespace App\Http\Controllers;

use App\Models\MCA\Article;
use App\Models\MCA\Category;
use App\Models\MCA\QuestionAnswerExpert;
use App\Models\MCA\SpecModel;
use App\Models\MCA\TypeModel;
use App\Models\MCA\TypeSuppliesModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class QuestionAnswerExpertCtrl extends BaseController
{
    public function index(Request $request, $active_menu)
    {
        $key_word = $request->key_word ?? '';
        $spec_id = $request->listSpec_id ?? '';
        $per_page = 5;
        $type = $active_menu == 'tu-van-chuyen-gia' ? 2 : 1;
        $questions = QuestionAnswerExpert::where('type', $type)
            ->filterByKeyWord($key_word)
            ->filterBySpec($spec_id)
            ->paginate($per_page);
        $listSpec = SpecModel::all();
        $data = [
            'listSpec' => $listSpec,
        ];
        $list_category = Category::all();
        $current_menu_top = 'answer-expert';
        $menu_right = (new MenuRightController())->getData();
        return view('frontend.questionAnswerExpert.questionAnswerExpert', compact(
            'questions', 
            'current_menu_top', 
            'active_menu',
            'list_category', 
            'menu_right',
            'data'
        ));
    }
    public function detail($active_menu, $id)
    {
        $type = $active_menu == 'tu-van-chuyen-gia' ? 2 : 1;
        $questions = QuestionAnswerExpert::with('comments.user', 'comments.medias')->where('type', $type)->find($id);
        $list_category = Category::all();
        $current_menu_top = 'answer-expert';
        $menu_right = (new MenuRightController())->getData();
        return view('frontend.questionAnswerExpert.questionAnswerExpertDetail', compact('questions', 'current_menu_top', 'active_menu', 'list_category', 'menu_right'));
    }
}
