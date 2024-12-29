<?php

namespace Innoboxrr\LaravelBlog\Models\Traits\Storage;

// use Innoboxrr\LaravelBlog\Models\BlogCategoryMeta;

trait BlogCategoryStorage
{

    public function createModel($request)
    {

        $blogCategory = $this->create($request->only($this->creatable));

        return $blogCategory;

    }

    public function updateModel($request)
    {
     
        $this->update($request->only($this->updatable));

        return $this;

    }

    /*
    public function updateModelMetas($request)
    {

        $this->update_metas($request, BlogCategoryMeta::class, 'blog_category_id')->updatePayload();

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