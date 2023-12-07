<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Traits\SlugTrait;
use App\Traits\FileManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\DeleteArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use Illuminate\Support\Facades\Log;

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

    public function update (UpdateArticleRequest $request, string $slug): JsonResponse
    {
        $article = Article::find($this->getId($slug));

        if ($request->file('image') && $article->image_path)
        {
            Storage::disk('public')->delete($article->image_path);
            $article->image_path = $request->file('image')->store('articles', 'public');
        }

        if ($article = tap($article)->update($request->validated()))
        {
            Log::channel('requestslog')->info($request->validated());
            return response()->json($article, Response::HTTP_OK);
        }

        return response()->json("Impossible d'éditer la ressource !", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete (DeleteArticleRequest $request, $slug): JsonResponse
    {
        $article = Article::find($this->getId($slug));

        if ($article->delete())
        {
            return response()->json([], Response::HTTP_OK);
        }

        return response()->json("Impossible de supprimer la ressource !", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
