@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/sweetalert/sweetalert2.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            @include('includes.admin-breadcrumb')

            <div class="col-lg-6">
                <a class="btn btn-success btn-lg pull-right ml-2 addEducation" href="javascript:void(0)" data-toggle="modal" data-target="#addResume">Add Education</a>
                <a class="btn btn-primary btn-lg pull-right addExperience" href="javascript:void(0)" data-toggle="modal" data-target="#addResume">Add Experience</a>
            </div>
        </div>
    </div>
</div>

@php
function formatDescription($text) {
    $lines = preg_split('/\r\n|\r|\n/', trim($text));

    // Check if most lines start with bullet marker
    $isList = collect($lines)->filter(function ($line) {
        return preg_match('/^(●● |-|\*)\s?/', trim($line));
    })->count() >= (count($lines) / 2); // majority rule

    if ($isList) {
        $html = '<ul>';
        foreach ($lines as $line) {
            $line = preg_replace('/^(●● |-|\*)\s?/', '', trim($line)); // remove bullet marker
            if ($line !== '') {
                $html .= "<li>{$line}</li>";
            }
        }
        $html .= '</ul>';
        return $html;
    }

    // Default: paragraph with <br>
    return '<p>'.nl2br(e($text)).'</p>';
}
@endphp

<div class="row">
    <!-- Left side: Education -->
    <div class="col-md-6">
        <h4 class="mb-3">Education</h4>
        <div class="list-group">
            @forelse($education as $edu)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="avatars d-flex align-items-center">
                        <div class="avatar">
                            <img src="{{ $edu->icon }}" alt="Logo" style="width: 90px; height: 50px; object-fit: contain; margin-right: 10px;">
                        </div>

                        <div>
                            <strong>{{ $edu->title }}</strong><br>
                            <small>{{ $edu->organization }}, {{ $edu->location }} | {{ $edu->from_year }} - {{ $edu->to_year }}</small>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-info btn-sm edit-resume"
                                data-id="{{ $edu->id }}"
                                data-type="education"
                                data-title="{{ $edu->title }}"
                                data-organization="{{ $edu->organization }}"
                                data-from-year="{{ $edu->from_year }}"
                                data-to-year="{{ $edu->to_year }}"
                                data-location="{{ $edu->location }}"
                                data-description="{{ $edu->description }}"
                                data-icon="{{ $edu->icon }}">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteResume({{ $edu->id }})">Delete</button>
                    </div>
                </div>

                @if($edu->description)
                <div class="list-group-item text-justify" style="margin-bottom: 30px">
                    <span class="text-muted">{!! formatDescription($edu->description) !!}</span>
                </div>
                @endif
            @empty
                <p class="text-muted">No Education entries found.</p>
            @endforelse
        </div>
    </div>

    <!-- Right side: Experience -->
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-3">Experience</h4>
        </div>

        <div class="list-group">
            @forelse($experience as $exp)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="avatars d-flex align-items-center">
                        <div class="avatar">
                            <img src="{{ $exp->icon }}" alt="Logo" style="width: 90px; height: 50px; object-fit: contain; margin-right: 10px;">
                        </div>

                        <div>
                            <strong>{{ $exp->title }}</strong><br>
                            <small>{{ $exp->organization }}, {{ $exp->location }} | {{ $exp->from_year }} - {{ $exp->to_year }}</small>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-info btn-sm edit-resume"
                                data-id="{{ $exp->id }}"
                                data-type="experience"
                                data-title="{{ $exp->title }}"
                                data-organization="{{ $exp->organization }}"
                                data-from-year="{{ $exp->from_year }}"
                                data-to-year="{{ $exp->to_year }}"
                                data-location="{{ $exp->location }}"
                                data-description="{{ $exp->description }}"
                                data-icon="{{ $exp->icon }}">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteResume({{ $exp->id }})">Delete</button>
                    </div>
                </div>

                <div class="list-group-item text-justify" style="margin-bottom: 30px">
                    <span class="text-muted">{!! formatDescription($exp->description) !!}</span>
                </div>
            @empty
                <p class="text-muted">No Experience entries found.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Resume Modal (common for Education/Experience) -->
<div class="modal fade" id="addResume" tabindex="-1" role="dialog" aria-labelledby="addResume" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="resumeForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add Resume Entry</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="resume_id">
                    <input type="hidden" name="type" id="resume_type">

                    <label>Title</label>
                    <input type="text" name="title" id="resume_title" class="form-control" placeholder="Enter Title">
                    <span class="title-error error-message text-danger"></span>
                    <br/>

                    <div class="form-row">
                        <div class="form-group col-md-6" style="margin-bottom: 0">
                            <label>Institution/Company/Organization</label>
                            <input type="text" name="organization" id="resume_institution" class="form-control" placeholder="Enter Institution or Company or Organization">
                            <span class="institution-error error-message text-danger"></span>
                            <br/>
                        </div>

                        <div class="form-group col-md-6" style="margin-bottom: 0">
                            <label>Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter Institution or Company Location">
                            <span class="location-error error-message text-danger"></span>
                            <br/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>From Year</label>
                            <select name="from_year" id="resume_from_year" class="form-control">
                                <option value="">Select From Year</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                            <span class="from-year-error error-message text-danger"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label>To Year</label>
                            <select name="to_year" id="resume_to_year" class="form-control">
                                <option value="">Select To Year</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}">{{ $year == date('Y') ? 'Present' : $year }}</option>
                                @endfor
                            </select>
                            <span class="to-year-error error-message text-danger"></span>
                        </div>
                    </div>


                    <label>Description (optional)</label>
                    <textarea name="description" id="resume_description" class="form-control" placeholder="Enter Description" rows="10"></textarea>
                    <br/>

                    <label>Organization Logo URL (optional)</label>
                    <input type="text" name="icon" id="resume_icon" class="form-control" placeholder="Enter Icon name">

                    <span class="resume-error error-message text-danger"></span>
                </div>
                <div class="modal-footer">
                    <span class="success-message text-success"></span>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="save_resume">
                        <span class="spinner-border spinner-border-sm" style="display:none"></span>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
$(document).ready(function () {
    // Save Resume (Education/Experience)
    $("#resumeForm").submit(function(e) {
        e.preventDefault();
        $("#save_resume").attr("disabled", true).find(".spinner-border").show();
        let id = $("#resume_id").val();
        let url = id ? base_url+"/admin/update-resume/"+id : base_url+"/admin/add-new-resume";

        $(".title-error").text('');
        $(".institution-error").text('');
        $(".location-error").text('');
        $(".from-year-error").text('');
        $(".to-year-error").text('');
        $(".description-error").text('');
        $(".icon-error").text('');
        $(".resume-error").text('');

        $.post(url, $(this).serialize())
            .done(() => {
                $(".success-message").text('Resume entry saved successfully');
                location.reload();
            })
            .fail(xhr => {
                $(".error-message").show();
                var object = JSON.parse(xhr.responseText);

                if(xhr.status === 422) {
                    $.each(object, function(key, value) {
                        $(".title-error").text(value.title ? value.title[0] : '');
                        $(".institution-error").text(value.organization ? value.organization[0] : '');
                        $(".location-error").text(value.location ? value.location[0] : '');
                        $(".from-year-error").text(value.from_year ? value.from_year[0] : '');
                        $(".to-year-error").text(value.to_year ? value.to_year[0] : '');
                        $(".description-error").text(value.description ? value.description[0] : '');
                        $(".icon-error").text(value.icon ? value.icon[0] : '');
                    });
                } else {
                    $(".resume-error").text('Something went wrong');
                }
            })
            .always(() => $("#save_resume").attr("disabled", false).find(".spinner-border").hide());
    });

    // Edit Resume
    $(".edit-resume").click(function() {
        $("#resume_id").val($(this).data("id"));
        $("#resume_type").val($(this).data("type"));
        $("#resume_title").val($(this).data("title"));
        $("#resume_institution").val($(this).data("organization"));
        $("#location").val($(this).data("location"));
        $("#resume_from_year").val($(this).data("from-year"));
        $("#resume_to_year").val($(this).data("to-year"));
        $("#resume_description").val($(this).data("description"));
        $("#resume_icon").val($(this).data("icon"));
        $("#addResume .modal-title").text("Edit Resume Entry");
        $("#save_resume span:last").text("Update");
        $("#addResume").modal("show");
    });

    // Add Education
    $(".addEducation").click(function() {
        $("#resumeForm")[0].reset();
        $("#resume_id").val('');
        $("#resume_type").val('education');
        $("#addResume .modal-title").text("Add Education");
        $("#save_resume span:last").text("Save");
        $(".error-message").text('');
    });

    // Add Experience
    $(".addExperience").click(function() {
        $("#resumeForm")[0].reset();
        $("#resume_id").val('');
        $("#resume_type").val('experience');
        $("#addResume .modal-title").text("Add Experience");
        $("#save_resume span:last").text("Save");
        $(".error-message").text('');
    });
});

function deleteResume(id) {
    swal({
        title: "Are you sure?",
        text: "Do you want to delete this resume entry?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: base_url+'/admin/delete-resume/'+id,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "success") {
                        swal("Deleted!", {
                            icon: "success",
                            title: "Success",
                        });
                        setTimeout(() => location.reload(), 1000);
                    }
                },
                error: function () {
                    swal("Something went wrong", { icon: "error", title: "Error" });
                }
            });
        }
    });
}
</script>
@endsection
