@foreach ($leads as $key => $value)
<tr>
    <td><input type="checkbox" name="select[]" value="{{$value['id']}}"></td>
    <td>{{$key+1}}</td>
    <td><a href="javascript::void()" data-toggle="modal" data-target="#leadStatus" onclick="triggerStatus({{$value->id}})">{{$value->name}}</a></td>
    <td><a href="tel:{{$value->contact_no}}">{{$value->contact_no}}</a></td>
    <td>{{$value->address}}</td>
    <!-- <td>{{$value->website}}</td> -->
    <td>{{$value->lead_category}}</td>
    <td>{{$value->remarks}}</td>

    @if($value->status == '0')
    <td><span class="badge badge-primary">Pending</span></td>
    @elseif($value->status == '1')
    <td><span class="badge badge-dark">Follow Up 1</span></td>
    @elseif($value->status == '3')
    <td><span class="badge badge-dark">Follow Up 3</span></td>
    @elseif($value->status == '3')
    <td><span class="badge badge-dark">Follow Up 3</span></td>
    @elseif($value->status == '4')
    <td><span class="badge badge-warning">Not Interested</span></td>
    @elseif($value->status == '5')
    <td><span class="badge badge-danger">Closed</span></td>
    @elseif($value->status == '6')
    <td><span class="badge badge-success">Invoiced</span></td>
    @endif

    <td>{{$value->created_at}}</td>

    <td>
        <button class="btn btn-xs btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="{{url('admin/edit-lead', $value->id)}}"><i class="fa fa-pencil m-r-5"></i>Edit</a>
        <a class="dropdown-item" href="javascript::void()" onclick="deleteLead({{$value->id}})"><i class="fa fa-trash m-r-5"></i>Delete</a>
        </div>
    </td>
</tr>
@endforeach