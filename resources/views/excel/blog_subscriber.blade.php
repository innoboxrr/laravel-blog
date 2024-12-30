<table>
    <thead>
        <tr>
            @foreach($exportCols as $col)
                <th>{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($blog_subscribers as $blog_subscriber)
            <tr>
                @foreach($exportCols as $col)
                    <td>{{ $blog_subscriber->$col }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>