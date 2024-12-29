<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogTagRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogTagStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogTagAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogTagOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogTagMutators;

class BlogTag extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogTagRelations,
        BlogTagStorage,
        BlogTagAssignment,
        BlogTagOperations,
        BlogTagMutators;
        
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
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogTagFactory::new();
    }
    */

}
