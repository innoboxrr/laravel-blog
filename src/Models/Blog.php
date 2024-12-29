<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogMutators;

class Blog extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogRelations,
        BlogStorage,
        BlogAssignment,
        BlogOperations,
        BlogMutators;
        
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
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogFactory::new();
    }
    */

}
