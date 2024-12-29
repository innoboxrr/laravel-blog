<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogPostRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogPostStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogPostAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogPostOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogPostMutators;

class BlogPost extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogPostRelations,
        BlogPostStorage,
        BlogPostAssignment,
        BlogPostOperations,
        BlogPostMutators;
        
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
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogPostFactory::new();
    }
    */

}
