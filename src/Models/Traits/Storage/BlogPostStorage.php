<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

use Illuminate\Support\Facades\DB;
use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Models\BlogPostMeta;

trait BlogPostStorage
{

    public function createModel($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $blogPost = $this->create($request->only($this->creatable));
                $blogPost->updateModelMetas($request);

                if ($request->has('tags')) {
                    $tags = collect(explode(',', $request->tags ?? ''))->map(function ($tag) use ($blogPost) {
                        return BlogTag::firstOrCreate([
                            'name' => $tag,
                            'blog_id' => $blogPost->blog_id,
                        ]);
                    });
                    $blogPost->tags()->sync($tags->pluck('id'));
                }

                if ($request->has('categories')) {
                    $blogPost->categories()->sync(explode(',', $request->categories ?? ''));
                }

                $blogPost->uploadFeaturedImage($request);

                return $blogPost;
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un problema al guardar el blog post.'], 500);
        }
    }

    public function updateModel($request)
    {
        $this->update($request->only($this->updatable));
        $this->updateModelMetas($request);
        return $this;
    }

    public function updateModelMetas($request)
    {
        $this->update_metas($request, BlogPostMeta::class, 'blog_post_id')->updatePayload();
        return $this;
    }

    public function deleteModel()
    {

        $this->delete();

    }

    public function restoreModel()
    {

        $this->restore();

    }

    public function forceDeleteModel()
    {

        abort(403);

        $this->forceDelete();
        
    }

}