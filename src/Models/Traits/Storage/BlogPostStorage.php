<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Models\BlogPostMeta;

trait BlogPostStorage
{

    public function createModel($request)
    {
        $blogPost = $this->create($request->only($this->creatable));
        $blogPost->updateModelMetas($request->except(['payload']));

        if ($request->has('tags')) {
            $tags = collect($request->tags ?? [])
                ->map(function ($tag) use ($blogPost) {
                    return BlogTag::firstOrCreate([
                        'name' => $tag,
                        'blog_id' => $blogPost->blog_id,
                    ]);
                });
            $blogPost->tags()->sync($tags->pluck('id'));
        }

        if ($request->has('categories')) {
            $blogPost->categories()
                ->sync($request->categories ?? []);
        }

        $blogPost->processFeaturedImage();

        $blogPost->blog->clearCache();

        return $blogPost;
    }

    public function updateModel($request)
    {
        $processImage = $request->original_image && $request->original_image !== $this->getPayload('images.original');

        $this->update($request->only($this->updatable));
        $this->updateModelMetas($request);

        if ($request->has('tags')) {
            $tags = collect($request->tags ?? [])
                ->map(function ($tag){
                    return BlogTag::firstOrCreate([
                        'name' => $tag,
                        'blog_id' => $this->blog_id,
                    ]);
                });
            $this->tags()->sync($tags->pluck('id'));
        }

        if ($request->has('categories')) {
            $this->categories()
                ->sync($request->categories ?? []);
        }

        if($processImage) {
            $this->processFeaturedImage();
        }

        $this->blog->clearCache();

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