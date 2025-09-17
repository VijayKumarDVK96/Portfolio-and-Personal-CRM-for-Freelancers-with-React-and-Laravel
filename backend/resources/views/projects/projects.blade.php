@extends('includes.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="page-header pb-0">
            <div class="row">
                @include('includes.admin-breadcrumb')

                <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg pull-right" href="{{url('admin/add-project')}}">Add New Project</a>
                </div>
            </div>

            <form action="" method="post" id="filter">
                <div class="row mt-5">
                    <div class="col-md-12 project-list">
                        <div class="card">
                            <div class="row filter-row">
                            <div class="col-sm-3 col-xs-6">  
                                <div class="form-group form-focus">
                                    <label class="control-label">Project Name</label>
                                    <select class="form-control" name="project_name"> 
                                        <option value="">Select Project</option>
                                        @foreach ($all_projects as $value)
                                        <option value="{{$value->name}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6"> 
                                <div class="form-group form-focus select-focus">
                                    <label class="control-label">Client Name</label>
                                    <select class="form-control" name="client_id"> 
                                        <option value="">Select Client Name</option>
                                        @forelse ($clients as $value)
                                            <option value="{{$value->id}}">{{$value->full_name}}</option>
                                        @empty
                                        <option value="">Select Client Name</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6"> 
                                <div class="form-group form-focus select-focus">
                                    <label class="control-label">Sort by</label>
                                    <select class="form-control" name="sort"> 
                                        <option value="">Select Sort By</option>
                                        <option value="desc">Date: Latest to Oldest</option>
                                        <option value="asc">Date: Oldest to Latest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6"> 
                                <div class="form-group form-focus select-focus">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" name="status"> 
                                        <option value="">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Completed</option>
                                        <option value="2">On Hold</option>
                                        <option value="3">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6 form-group">  
                                <button type="submit" class="btn btn-success btn-block"> Search </button>  
                            </div>
                            <div class="col-sm-2 col-xs-6 form-group">  
                                <button type="button" id="reset" class="btn btn-danger btn-block"> Reset </button>  
                            </div>     
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="top-tabContent">
                    <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                        <div class="row projects">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    readProjects();

    function readProjects(pageno='') {
        if(pageno=='')
        $(".projects").html('<div class="col-md-12"><h3 style="padding: .75rem 1.25rem;">Loading...</h3></div>');
        
        var link = (pageno=='') ? base_url+"/admin/read-projects-ajax/" : base_url+"/admin/read-projects-ajax/?page="+pageno;

        $.ajax({
            url: link,
            dataType: 'json',
            data: $("#filter").serialize(),
            method: "post",
            success: function(data) {
                if(data.count > 0)
                $(".projects").html(data.view);
                else
                $(".projects").html('<div class="col-md-12"><h3 style="padding: .75rem 1.25rem;">No Projects Available</h3></div>');
            }
        });
    }

    $("#filter").submit(function(e) {
        e.preventDefault();
        readProjects();
    });

    $("#reset").click(function(e) {
        $("#filter").find('input:text, input:password, input:file, select, textarea').val('');
        $("#filter").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

        $("#filter").trigger("reset");
        $("#filter").trigger("submit");
    });
</script>
@endsection