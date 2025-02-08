<div>
    <h2>Blog: {{ $blog->name }}</h2>
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ blog_route('post', $post) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
    {{ $posts->links() }}
</div>
