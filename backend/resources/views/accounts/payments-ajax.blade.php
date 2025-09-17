@foreach ($payments as $key => $value)
<tr>
    <td>{{$key+1}}</td>
    <td>{{$value->client_name}}</td>
    <td>{{$value->project_name}}</td>
    <td>{{$value->payment_type}}</td>
    <td>{{($value->statement_type == 1) ? 'Rs.'.$value->paid_amount : '-'}}</td>
    <td>{{($value->statement_type == 0) ? 'Rs.'.$value->paid_amount : '-'}}</td>
    @if($value->statement_type == 1)
    <td><span class="badge badge-success">Credit</span></td>
    @else
    <td><span class="badge badge-danger">Debit</span></td>
    @endif
    <td>{{$value->purpose}}</td>
    <td>{{$value->description}}</td>
    <td>{{$value->paid_at}}</td>
    <td>{{$value->created_at}}</td>

    <td>
        <button class="btn btn-xs btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</button>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="{{url('admin/edit-payment', $value->id)}}"><i class="fa fa-pencil m-r-5"></i>Edit</a>
        <a class="dropdown-item" href="javascript::void()" onclick="deletePayment({{$value->id}})"><i class="fa fa-trash m-r-5"></i>Delete</a>
        </div>
    </td>
</tr>
@endforeach