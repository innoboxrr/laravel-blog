<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

// use Innoboxrr\LaravelBlog\Models\BlogTagMeta;

trait BlogTagStorage
{

    public function createModel($request)
    {

        $blogTag = $this->create($request->only($this->creatable));

        return $blogTag;

    }

    public function updateModel($request)
    {
     
        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, BlogTagMeta::class, 'blog_tag_id')->updatePayload();

        return $this;

    }
    */

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