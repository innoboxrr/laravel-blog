<table>
    <thead>
        <tr>
            @foreach($exportCols as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($blog_posts as $blog_post)
            <tr>
                @foreach($exportCols as $col)
                    <td>{{ $blog_post->$col }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>