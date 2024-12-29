<table>
    <thead>
        <tr>
            @foreach($exportCols as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($blog_tags as $blog_tag)
            <tr>
                @foreach($exportCols as $col)
                    <td>{{ $blog_tag->$col }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>