@foreach ($certifications as $index => $item)
<tr>
    <td>{{ $index+1 }}</td>
    <td>{{ $item->category->name ?? 'N/A' }}</td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->issued_by }}</td>
    <td>{{ $item->issued_date }}</td>
    <td>
        <button class="btn btn-sm btn-primary" onclick="editCertification({{ $item->id }})">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="deleteCertification({{ $item->id }})">Delete</button>
    </td>
</tr>
@endforeach