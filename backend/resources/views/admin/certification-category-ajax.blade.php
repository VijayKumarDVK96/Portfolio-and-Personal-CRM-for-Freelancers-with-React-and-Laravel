@foreach ($categories as $index => $item)
<tr>
    <td>{{ $index+1 }}</td>
    <td>{{ $item->name }}</td>
    <td>
        <button class="btn btn-sm btn-primary" onclick="editCategory({{ $item->id }})">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="deleteCategory({{ $item->id }})">Delete</button>
    </td>
</tr>
@endforeach