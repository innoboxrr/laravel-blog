<?php

namespace Innoboxrr\LaravelBlog\Jobs\BlogPost;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Innoboxrr\LaravelBlog\Models\BlogPost;
use Innoboxrr\LaravelBlog\Services\BlogPost\FeaturedImageService;

class ProcessFeaturedImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $blogPost;

    public function __construct(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    public function handle()
    {
        FeaturedImageService::processImage($this->blogPost);
    }
}
