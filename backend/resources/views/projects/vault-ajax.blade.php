@foreach ($vault as $key => $value)
<tr>
    <th>{{$key+1}}</th>
    <td>{{$value->vaults_category->name}}</td>
    <td><a target="_blank" href="{{$value->url}}">{{$value->url}}</a></td>
    <td>
        <span class="credentials">*****</span> 
        <span class="toggle-credentials-open" onclick="toggleCredentials('{{Crypt::decryptString($value->username)}}', this)"><i class="fa fa-eye"></i></span>
    </td>
    <td>
        <span class="credentials">*****</span> 
        <span class="toggle-credentials-open" onclick="toggleCredentials('{{Crypt::decryptString($value->password)}}', this)"><i class="fa fa-eye"></i></span>
    </td>
    @php
        $notes = Crypt::decryptString($value->notes);
    @endphp
    <td>
        @if(isset($notes) && $notes != '')
        <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#vaultNotes" onclick="appendNotes({{$value->id}})">View Notes</button>
        @else
        -
        @endif
    </td>
    <td>
        <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#editVault" onclick="editVault({{$value->id}})"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger btn-sm" type="button" onclick="deleteCredentials({{$value->id}})"><i class="fa fa-trash"></i></button>
    </td>
</tr>
@endforeach