<tr>
    <th scope="row">{{ $url->id }}</th>
    <td>{{ $url->code }}</td>
    <td>{{ $url->hits }}</td>
    <td>{{ $url->url }}</td>
    <td>{{ $url->status }}</td>
    <td>{{ $url->expires }}</td>
    <td>{{ $url->created }}</td>
    <td>{{ $url->updated }}</td>
    <td>
        @if ($url->status == 'active')
            <a href="#"
               onclick="event.preventDefault();
                       document.getElementById('delete-id').value = '{{ $url->id  }}';
                       document.getElementById('delete-form').submit();">
                remove
            </a>
        @endif
    </td>
</tr>
