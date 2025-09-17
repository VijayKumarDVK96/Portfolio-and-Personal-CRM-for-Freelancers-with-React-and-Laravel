@foreach ($estimates as $key => $value)
<tr>
    <td>{{$key+1}}</td>
    <td><a href="{{url('admin/view-estimate/'.$value->id)}}">{{$value->estimate_number}}</a></td>
    <td>{{$value->client_name}}</td>
    <td>{{$value->estimate_date}}</td>
    <td>{{$value->expiry_date}}</td>
    <td>{{$value->currency}} {{$value->amount}}</td>

    @if($value->status == 'Open')
    <td><span class="badge badge-primary">{{$value->status}}</span></td>
    @elseif($value->status == 'Sent')
    <td><span class="badge badge-warning">{{$value->status}}</span></td>
    @elseif($value->status == 'Invoiced')
    <td><span class="badge badge-success">{{$value->status}}</span></td>
    @elseif($value->status == 'Declined')
    <td><span class="badge badge-danger">{{$value->status}}</span></td>
    @endif

    <td>
        <button class="btn btn-xs btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="{{url('admin/edit-estimate', $value->id)}}"><i class="fa fa-pencil m-r-5"></i>Edit</a>
        <a class="dropdown-item" href="javascript::void()" onclick="deleteEstimate({{$value->id}})"><i class="fa fa-trash m-r-5"></i>Delete</a>
        </div>
    </td>
</tr>
@endforeach