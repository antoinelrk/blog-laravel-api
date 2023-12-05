<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Traits\SlugTrait;
use App\Traits\FileManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;

class ArticleController extends Controller
{
    use SlugTrait, FileManager;
    
    public function __construct()
    {
        $this->middleware('api');
    }

    public function list (): JsonResponse
    {
        $articles = Article::paginate(10);
        return response()->json($articles, Response::HTTP_OK);
    }

    public function get ($slug): JsonResponse
    {
        $article = Article::find($this->getId($slug));
        return response()->json($article, Response::HTTP_OK);
    }

    public function create (CreateArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        /** @var UploadedFile $image */
        $image = $request->validated('image');

        if ($image !== null && !$image->getError())
        {
            $data['image_path'] = $image->store('articles', 'public');
        }

        $article = new Article($data);

        if ($article->save())
        {
            return response()->json($article, Response::HTTP_CREATED);
        }

        return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update (UpdateArticleRequest $request, int $id): JsonResponse
    {
        $article = Article::find($id);

        if ($request->file('image') && $article->image_path)
        {
            Storage::disk('public')->delete($article->image_path);
            $article->image_path = $request->file('image')->store('articles', 'public');
        }

        if ($article->update($request->validated()))
        {
            dd('ok');
        }
        else
        {
            dd('pas ok');
        }

        return response()->json($article, Response::HTTP_OK);
    }
}
