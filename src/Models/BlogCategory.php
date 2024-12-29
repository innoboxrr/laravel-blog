<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogCategoryRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogCategoryStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogCategoryAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogCategoryOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogCategoryMutators;

class BlogCategory extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogCategoryRelations,
        BlogCategoryStorage,
        BlogCategoryAssignment,
        BlogCategoryOperations,
        BlogCategoryMutators;
        
    protected $fillable = [
        //FILLABLE//
    ];

    protected $creatable = [
        //CREATABLE//
    ];

    protected $updatable = [
        //UPDATABLE//
    ];

    protected $casts = [
        //CASTS//
    ];

    protected $protected_metas = [];

    protected $editable_metas = [
        //EDITABLEMETAS//
    ];

    public static $export_cols = [
        //EXPORTCOLS//
    ];

    public static $loadable_relations = [
        //LOADABLERELATIONS//
    ];

    public static $loadable_counts = [
        //LOADABLECOUNTS//
    ];

    /*
    protected static function newFactory()
    {
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogCategoryFactory::new();
    }
    */

}
