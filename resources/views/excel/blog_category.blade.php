<table>
    <thead>
        <tr>
            @foreach($exportCols as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($blog_categories as $blog_category)
            <tr>
                @foreach($exportCols as $col)
                    <td>{{ $blog_category->$col }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>