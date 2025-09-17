@foreach ($enquiries as $key => $value)
<tr>
    <th>{{$key+1}}</th>
    <td>{{$value->name}}</td>
    <td>{{$value->email}}</td>
    <td>{{$value->phone}}</td>
    <td>{{$value->subject}}</td>
    <td>{{$value->message}}</td>
    <td>
        @if($value->status == 0)
        <span class="badge badge-warning">Pending</span>
        @elseif($value->status == 1)
        <span class="badge badge-success">Confirmed</span>
        @elseif($value->status == 2)
        <span class="badge badge-primary">Invoiced</span>
        @endif
    </td>
    <td>{{$value->notes ?? '-'}}</td>
    <td>{{$value->created_at}}</td>
    <td>{{$value->updated_at}}</td>
    <td>
        <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#editEnquiry" onclick="editEnquiry({{$value->id}})"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger btn-sm" type="button" onclick="deleteEnquiry({{$value->id}})"><i class="fa fa-trash"></i></button>
    </td>
</tr>
@endforeach