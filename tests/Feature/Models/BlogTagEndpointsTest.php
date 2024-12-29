<?php

namespace Innoboxrr\LaravelBlog\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Innoboxrr\LaravelBlog\Tests\TestCase;

class BlogTagEndpointsTest extends TestCase
{

    use RefreshDatabase,
        WithFaker;

    public function test_blog_tag_policies_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::factory()->create();
        
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'id' => $blogTag->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-tag/policies', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_tag_policy_endpoint()
    {
        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'policy' => 'index'
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-tag/policy', $payload, $headers)
            ->assertJsonStructure([
                'index'
            ])
            ->assertStatus(200);

    }

    public function test_blog_tag_index_auth_endpoint()
    {

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-tag/index', $payload, $headers)
            ->assertStatus(200);

    }

    public function test_blog_tag_index_guest_endpoint()
    {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'managed' => true
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-tag/index', $payload, $headers)
            ->assertStatus(401);
            
    }
    
    public function test_blog_tag_show_auth_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_tag_id' => $blogTag->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-tag/show', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_tag_show_guest_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::latest()->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_tag_id' => $blogTag->id
        ];

        $this->json('GET', '/api/innoboxrr/laravelblog/blog-tag/show', $payload, $headers)
            ->assertStatus(401);
            
    }

    public function test_blog_tag_create_endpoint()
    {

        $user = \Innoboxrr\LaravelBlog\Models\User::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = \Innoboxrr\LaravelBlog\Models\BlogTag::factory()->make()->getAttributes();

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-tag/create', $payload, $headers)
            ->assertStatus(201);
            
    }

    public function test_blog_tag_update_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::factory()->create();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            ...\Innoboxrr\LaravelBlog\Models\BlogTag::factory()->make()->getAttributes(),
            'blog_tag_id' => $blogTag->id
        ];

        $this->json('PUT', '/api/innoboxrr/laravelblog/blog-tag/update', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_tag_delete_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_tag_id' => $blogTag->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-tag/delete', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_tag_restore_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_tag_id' => $blogTag->id
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-tag/restore', $payload, $headers)
            ->assertStatus(200);
            
    }

    public function test_blog_tag_force_delete_endpoint()
    {

        $blogTag = \Innoboxrr\LaravelBlog\Models\BlogTag::latest()->first();

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            'blog_tag_id' => $blogTag->id
        ];

        $this->json('DELETE', '/api/innoboxrr/laravelblog/blog-tag/force-delete', $payload, $headers)
            ->assertStatus(403);
            
    }

    public function test_blog_tag_export_endpoint()
    {   

        $headers = [
            'Authorization' => config('test.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];  

        $payload = [
            //
        ];

        $this->json('POST', '/api/innoboxrr/laravelblog/blog-tag/export', $payload, $headers)
            ->assertStatus(200);
            
    }

}
