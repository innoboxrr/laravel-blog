<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

use Innoboxrr\LaravelBlog\Models\BlogTag;
use Innoboxrr\LaravelBlog\Models\BlogPostMeta;

trait BlogPostStorage
{

    public function createModel($request)
    {
        $blogPost = $this->create($request->only($this->creatable));
        $blogPost->updateModelMetas($request);
        if($request->has('tags')) {
            $tags = collect($request->tags)->map(function($tag) {
                return BlogTag::firstOrCreate(['name' => $tag]);
            });
            $blogPost->tags()->sync($tags->pluck('id'));
        }
        if($request->has('categories')) {
            $blogPost->categories()->sync($request->categories);
        }
        $blogPost->setFeaturedImage($request);
        return $blogPost;
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