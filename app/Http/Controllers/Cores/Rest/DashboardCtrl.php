<?php
namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use Illuminate\Http\Request;
use App\Models\MCA\Article;
use App\Models\MCA\Category;

class DashboardCtrl extends RestController
{
    public function getHightlightArticle(Request $request){
        $params = $request->all();
        $per_page = $params['per_page']??null;
        $articles = Article::with('user','medias')
            ->where('status',Article::STATUS_ACTIVE)
            ->where('is_hightlight',Article::IS_HIGHTLIGHT)
            ->setPaginate($per_page);

        return response()->json($articles);
    }

    public function getCategory(){
        $categories = Category::where('status',Category::STATUS_ACTIVE)
                    ->get();
        return response()->json($categories);
    }

    public function getSingleArticle($id){
        $article = Article::where('status',Article::STATUS_ACTIVE)
                        ->with('medias','user')
                        ->where('id',$id)->first();
        return response()->json($article);
    }

    public function getArticleByCategory($id){
        $articles = Article::where('status',Article::STATUS_ACTIVE)
            ->with('medias','user')
            ->where('category_id',$id)->get();
        return response()->json($articles);
    }

}