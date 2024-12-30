<?php

namespace Innoboxrr\LaravelBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Innoboxrr\LaravelBlog\Models\Traits\Relations\BlogSubscriberRelations;
use Innoboxrr\LaravelBlog\Models\Traits\Storage\BlogSubscriberStorage;
use Innoboxrr\LaravelBlog\Models\Traits\Assignments\BlogSubscriberAssignment;
use Innoboxrr\LaravelBlog\Models\Traits\Operations\BlogSubscriberOperations;
use Innoboxrr\LaravelBlog\Models\Traits\Mutators\BlogSubscriberMutators;

class BlogSubscriber extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        ModelAppendsTrait,
        BlogSubscriberRelations,
        BlogSubscriberStorage,
        BlogSubscriberAssignment,
        BlogSubscriberOperations,
        BlogSubscriberMutators;
        
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
        return \Innoboxrr\LaravelBlog\Database\Factories\BlogSubscriberFactory::new();
    }
    */

}
