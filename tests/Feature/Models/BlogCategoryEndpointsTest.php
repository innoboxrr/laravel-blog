<?php

namespace Innoboxrr\LaravelBlog\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Innoboxrr\LaravelBlog\Tests\TestCase;

class BlogCategoryEndpointsTest extends TestCase
{

    use RefreshDatabase,
        WithFaker;

    public function test_blog_category_policies_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::factory()->create();
        
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'id' => $blogCategory->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-category/policies', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_category_policy_endpoint()
    {
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'policy' => 'index'
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-category/policy', $payload, $headers)
            ->assertJsonStructure([
                'index'
            ])
            ->assertStatus(200);

    }

    public function test_blog_category_index_auth_endpoint()
    {

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-category/index', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_category_index_guest_endpoint()
    {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-category/index', $payload, $headers)
            ->assertStatus(401);
            
    }
    
    public function test_blog_category_show_auth_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_category_id' => $blogCategory->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-category/show', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_category_show_guest_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::latest()->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_category_id' => $blogCategory->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-category/show', $payload, $headers)
            ->assertStatus(401);
            
    }

    public function test_blog_category_create_endpoint()
    {

        $user = \Innoboxrr\LaravelBlog\Models\User::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = \Innoboxrr\LaravelBlog\Models\BlogCategory::factory()->make()->getAttributes();

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-category/create', $payload, $headers)
            ->assertStatus(201);
            
    }

    public function test_blog_category_update_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::factory()->create();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            ...\Innoboxrr\LaravelBlog\Models\BlogCategory::factory()->make()->getAttributes(),
            'blog_category_id' => $blogCategory->id
        ];

        $this->json('PUT', '/api/innoboxrr/laravelblog/blog-category/update', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_category_delete_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_category_id' => $blogCategory->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-category/delete', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_category_restore_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_category_id' => $blogCategory->id
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-category/restore', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_category_force_delete_endpoint()
    {

        $blogCategory = \Innoboxrr\LaravelBlog\Models\BlogCategory::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_category_id' => $blogCategory->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-category/force-delete', $payload, $headers)
            ->assertStatus(403);
            
    }

    public function test_blog_category_export_endpoint()
    {   

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            //
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-category/export', $payload, $headers)
            ->assertStatus(200);
            
    }

}
