<table>
    <thead>
        <tr>
            @foreach($exportCols as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($blogs as $blog)
            <tr>
                @foreach($exportCols as $col)
                    <td>{{ $blog->$col }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>