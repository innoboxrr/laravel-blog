<?php
 
namespace Innoboxrr\LaravelBlog\Observers;
 
use Innoboxrr\LaravelBlog\Models\BlogCategory;
 
class BlogCategoryObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the BlogCategory "created" event.
     */
    public function created(BlogCategory $blogCategory): void
    {
        $blogCategory->log('created');
    }
 
    /**
     * Handle the BlogCategory "updated" event.
     */
    public function updated(BlogCategory $blogCategory): void
    {
        $blogCategory->log('updated');
    }
 
    /**
     * Handle the BlogCategory "deleted" event.
     */
    public function deleted(BlogCategory $blogCategory): void
    {
        $blogCategory->log('deleted');
    }
 
    /**
     * Handle the BlogCategory "restored" event.
     */
    public function restored(BlogCategory $blogCategory): void
    {
        $blogCategory->log('restored');
    }
 
    /**
     * Handle the BlogCategory "forceDeleted" event.
     */
    public function forceDeleted(BlogCategory $blogCategory): void
    {
        $blogCategory->log('forceDeleted');
    }
}