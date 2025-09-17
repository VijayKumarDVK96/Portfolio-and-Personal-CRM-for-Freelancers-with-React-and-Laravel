<div class="col-xl-4 col-md-4">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
        aria-orientation="vertical">
        @foreach ($clients as $key => $value)
        <a class="contact-tab-{{$key}} nav-link @if($key == 0) active show @endif" id="v-pills-user-tab" data-toggle="pill" onclick="activeDiv({{$key}})" href="#v-pills-user" role="tab" aria-controls="v-pills-user"
            aria-selected="true" data-original-title="" title="">
            <div class="media"><img class="img-50 img-fluid m-r-20 rounded-circle update_img_{{$key}}" src="@if($value->gender == 'Male') {{url('admin-assets/images/male.png')}} @else {{url('admin-assets/images/female.png')}} @endif" alt=""
                    data-original-title="" title="">
                <div class="media-body">
                    <h6> <span class="first_name_{{$key}}">{{$value->full_name}} </span></h6>
                    <p>{{$value->email}}</p>
                </div>
            </div>
        </a>
        @endforeach

        {{ $clients->links()}}
    </div>
</div>

<div class="col-xl-8 col-md-8" style="background-color: rgba(116, 103, 255, 0.1);">
    <div class="tab-content" id="v-pills-tabContent">
        @foreach ($clients as $key => $value)
        <div class="tab-pane contact-tab-{{$key}} tab-content-child fade @if($key == 0) active show @endif" id="v-pills-user" role="tabpanel" aria-labelledby="v-pills-user-tab">
            <div class="profile-mail">
                <div class="media"><img
                        class="img-100 img-fluid m-r-20 rounded-circle update_img_{{$key}}"
                        src="@if($value->gender == 'Male') {{url('admin-assets/images/male.png')}} @else {{url('admin-assets/images/female.png')}} @endif" alt=""
                        data-original-title="" title="">
                    <input class="updateimg" type="file" name="img"
                        onchange="readURL(this,{{$key}})" data-original-title="" title="">
                    <div class="media-body mt-0">
                        <h5><span>{{$value->full_name}} </span></h5>
                        <p>{{$value->email}}</p>
                        <ul>
                            <li><a href="javascript::void()" class="btn btn-info" onclick="editClient({{$value->id}})">Edit</a></li>
                            <li><a href="javascript::void()" class="btn btn-secondary" onclick="deleteClient({{$value->id}})">Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="email-general">
                    <h6 class="mb-3">Contact Details</h6>
                    <ul>
                        <li>Full Name <span class="full_name_{{$value->id}}">{{$value->full_name}}</span></li>
                        <li>Company Name<span class="company_name_{{$value->id}}">{{$value->company_name}}</span></li>
                        <li>Company Website<span class="company_website_{{$value->id}}">{{$value->company_website}}</span></li>
                        <li>Gender<span class="gender_{{$value->id}}">{{$value->gender}}</span></li>
                        <li>Role<span class="role_{{$value->id}}">{{$value->role}}</span></li>
                        <li>Email Address <span class="email_add_{{$value->id}}">{{$value->email}}</span></li>
                        <li>Mobile No<span class="mobile_{{$value->id}}">{{$value->mobile}}</span></li>
                        <li>Address<span class="address_{{$value->id}}">{{$value->address}}</span></li>
                        <li>State<span class="state_{{$value->id}}">{{$value->state}}</span></li>
                        <li>City<span class="city_{{$value->id}}">{{$value->city}}</span></li>

                        <li hidden><span class="state_id_{{$value->id}}">{{$value->state_id}}</span></li>
                        <li hidden><span class="city_id_{{$value->id}}">{{$value->city_id}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="contact-editform pl-0" style="display: none;">
        <h3>Edit Details</h3>
        <form action="#" id="updateClient">
            @csrf
            <div class="form-row">
                <div class="form-group mb-3 col-sm-6">
                    <label>Full Name <span class="mandatory">*</span></label>
                    <input class="form-control" type="text" placeholder="Full Name" id="full_name" name="full_name">
                    <input type="hidden" name="id" id="id">
                    <span class="name-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>Company Name <span class="mandatory">*</span></label>
                    <input class="form-control" type="text" placeholder="Company Name" id="company_name" name="company_name">
                    <span class="company-name-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>Company Website </label>
                    <input class="form-control" type="url" placeholder="Company Website" id="company_website" name="company_website">
                    <span class="company-website-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>Gender <span class="mandatory">*</span></label>
                    <select class="form-control btn-square" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <span class="gender-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>Role <span class="mandatory">*</span></label>
                    <input class="form-control" type="text" placeholder="Role" id="role" name="role">
                    <span class="role-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>Email Address <span class="mandatory">*</span></label>
                    <input class="form-control" type="text" autocomplete="off" id="email" name="email">
                    <span class="email-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>Mobile Number <span class="mandatory">*</span></label>
                    <input class="form-control" type="number" placeholder="Mobile Number" id="mobile" name="mobile">
                    <span class="mobile-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-12">
                    <label>Address <span class="mandatory">*</span></label>
                    <input class="form-control" type="text" placeholder="Address" id="address" name="address">
                    <span class="address-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>State <span class="mandatory">*</span></label>
                    <select class="form-control btn-square" id="state" name="state" onchange="changeCity()">
                        <option value="">Select State</option>
                        @forelse ($states as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @empty
                        <option value="">Select State</option>
                        @endforelse
                    </select>

                    <span class="state-error error-message"></span>
                </div>
                <div class="form-group mb-3 col-sm-6">
                    <label>City <span class="mandatory">*</span></label>
                    <select class="form-control btn-square" id="city" name="city">
                        <option value="">Select City</option>
                        @foreach ($cities as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    
                    <span class="city-error error-message"></span>
                </div>
            </div>
            <button id="update_client" class="btn btn-secondary update-contact" type="button"  onclick="updateClient()">
                <span class="spinner-border spinner-border-sm"></span>
                <span>Save</span>
            </button>
            <button class="btn btn-primary cancel-contact" type="button" onclick="cancel_contact()">Close</button>
        </form>

        <span class="success-message"></span>
        <span class="client-error error-message"></span>
    </div>
</div>