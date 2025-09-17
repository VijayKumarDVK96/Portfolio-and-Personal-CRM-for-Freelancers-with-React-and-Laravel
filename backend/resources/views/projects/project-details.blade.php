@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/todo/todo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/photoswipe/photoswipe.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
                <div class="col-lg-6">
                    <a class="btn btn-info pull-right" href="{{url('admin/edit-project', $id)}}">Edit Project</a>
                    <a class="btn btn-secondary mr-2 pull-right" href="{{url('admin/vault', $id)}}">Vault</a>
                    <a class="btn btn-primary mr-2 pull-right" href="{{url('admin/project-tasks', $id)}}">Tasks</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="card-body">
                <div class="ribbon-wrapper-right card">
                    @if($project->status)
                    <div class="ribbon ribbon-clip-right ribbon-right ribbon-success">Completed</div>
                    @else
                    <div class="ribbon ribbon-clip-right ribbon-right ribbon-warning">Pending</div>
                    @endif

                    <div class="card-header">
                        <h5>{{$project->name}}</h5>
                        <span>{{$project->pending_tasks_count}} open tasks, {{$project->completed_tasks_count}} tasks completed</span>
                    </div>
                    <div class="card-body p-10">
                        {!!$project->description!!}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h5>Portfolio Images</h5>
                    </div>
                    <div class="card-body">
                        @if(count($project->galleries) > 0)
                            <div class="my-gallery row" itemscope="">
                                @foreach ($project->galleries as $gallery)
                                    <figure class="col-xl-3 col-md-4 col-6" itemprop="associatedMedia" itemscope="">
                                        <a href="{{url('images/projects').'/'.$gallery->name}}" itemprop="contentUrl" data-size="1920x900">
                                            <img class="img-thumbnail" src="{{url('images/projects').'/'.$gallery->name}}" itemprop="thumbnail" alt="Image description">
                                        </a>
                                        {{-- <figcaption itemprop="caption description">Image caption 1</figcaption> --}}
                                    </figure>
                                @endforeach
                            </div>
                        @else
                            <h3>No Gallery Images</h3>
                        @endif

                        <!-- Root element of PhotoSwipe. Must have class pswp.-->
                        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="pswp__bg"></div>
                            <div class="pswp__scroll-wrap">
                            <div class="pswp__container">
                                <div class="pswp__item"></div>
                                <div class="pswp__item"></div>
                                <div class="pswp__item"></div>
                            </div>
                            <div class="pswp__ui pswp__ui--hidden">
                                <div class="pswp__top-bar">
                                <div class="pswp__counter"></div>
                                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                <button class="pswp__button pswp__button--share" title="Share"></button>
                                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                    <div class="pswp__preloader__cut">
                                        <div class="pswp__preloader__donut"></div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                <div class="pswp__share-tooltip"></div>
                                </div>
                                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                                <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel">
                <div class="panel-body">
                    <h6 class="panel-title m-b-15">Project details</h6>
                    <table class="table table-striped table-border">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="thumb">
                                        @if($project->thumbnail_image)
                                            <img src="{{url('images/projects/thumbnail/'.$project->thumbnail_image)}}" width="100%" alt="">
                                        @else
                                            <img src="{{url('admin-assets/images/placeholder.png')}}" width="100%" alt="">
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Project Category:</td>
                                <td class="text-right">{{$project->projects_category->name}}</td>
                            </tr>
                            <tr>
                                <td>Client Name:</td>
                                <td class="text-right">{{$project->client->full_name}}</td>
                            </tr>
                            <tr>
                                <td>Estimated Price:</td>
                                <td class="text-right">Rs {{$project->estimated_price}}</td>
                            </tr>
                            <tr>
                                <td>Total Price:</td>
                                <td class="text-right">Rs {{$project->estimated_price}}</td>
                            </tr>
                            <tr>
                                <td>Created:</td>
                                <td class="text-right">{{date('d-m-Y', strtotime($project->created_at))}}</td>
                            </tr>
                            <tr>
                                <td>Deadline:</td>
                                <td class="text-right">{{date('d-m-Y', strtotime($project->deadline))}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @foreach($project->technologies as $technologies)
                                        <button class="btn btn-primary btn-xs" type="button">{{$technologies->name}}</button>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="media mb-0 mt-2">
                                        <p> @if($project->pending_tasks_count == 0 && $project->completed_tasks_count == $project->project_tasks_count) 100 @else {{round($project->completed_tasks_count*100/$project->project_tasks_count)}} @endif%</p>
                                        <div class="media-body text-right"><span>Task Completed</span></div>
                                    </div>
                                    <div class="progress" style="height: 5px">
                                        <div class="progress-bar-animated @if($project->status == 0){{'bg-primary'}}@elseif($project->status == 1){{'bg-success'}} @endif progress-bar-striped"
                                    role="progressbar" style="width: @if($project->pending_tasks_count == 0 && $project->completed_tasks_count == $project->project_tasks_count) 100% @else {{round($project->completed_tasks_count*100/$project->project_tasks_count)}}% @endif" aria-valuenow="10" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="media mb-0 mt-2">
                                        <p> @if($project->pending_milestones_count == 0 && $project->completed_milestones_count == $project->project_milestones_count) {{100}} @else {{round($project->completed_milestones_count*100/$project->project_milestones_count)}} @endif%</p>
                                        <div class="media-body text-right"><span>Milestones Completed</span></div>
                                    </div>
                                    <div class="progress" style="height: 5px">
                                        <div class="progress-bar-animated @if($project->status == 0){{'bg-info'}}@elseif($project->status == 1){{'bg-success'}} @endif progress-bar-striped"
                                            role="progressbar" style="width: @if($project->pending_milestones_count == 0 && $project->completed_milestones_count == $project->project_milestones_count) 100% @else {{round($project->completed_milestones_count*100/$project->project_milestones_count)}}% @endif" aria-valuenow="10" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    

                    
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                <h5>Milestones</h5>
                </div>
                <div class="card-body">
                <div class="todo">
                    <div class="todo-list-wrapper">
                        <div class="todo-list-container">
                            <div class="todo-list-body">
                                <ul id="todo-list">
                                    @foreach ($project->project_milestones as $value)
                                        @if($value->status == 1)
                                        <li class="task completed">
                                        @else
                                        <li class="task">
                                        @endif
                                        
                                        <div class="task-container">
                                            <h4 class="task-label">{{$value->name}} </h4>
                                            <span class="task-action-btn">
                                                <span class="action-box large delete-btn" title="Delete Task" onclick="updateMilestone({{$value->id}}, 'delete')"><i class="icon"><i class="fa fa-times-circle"></i></i></span>
                                            
                                                <span class="action-box large complete-btn" title="Mark Complete" onclick="updateMilestone({{$value->id}}, 'update')"><i class="icon"><i class="fa fa-check-square"></i></i></span>
                                            </span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="todo-list-footer">
                                <div class="add-task-btn-wrapper"><span class="add-task-btn">
                                    <button class="btn btn-primary"><i class="icon-plus"></i> Add New</button></span></div>
                                <div class="new-task-wrapper">
                                    <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                    <span class="btn btn-danger cancel-btn" id="close-task-panel">Close</span>
                                    <span class="btn btn-success ml-3 add-new-task-btn" id="add-milestone">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        <span>Add</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notification-popup hide">
                        <p><span class="task"></span><span class="notification-text"></span></p>
                    </div>
                </div>
                <!-- HTML Template for tasks-->
                <script id="task-template" type="tect/template">
                    <li class="task">
                    <div class="task-container">
                    <h4 class="task-label"></h4>
                    <span class="task-action-btn">
                    <span class="action-box large delete-btn" title="Delete Task">
                    <i class="icon"><i class="fa fa-times-circle"></i></i>
                    </span>
                    <span class="action-box large complete-btn" title="Mark Complete">
                    <i class="icon"><i class="fa fa-check-square"></i></i>
                    </span>
                    </span>
                    </div>
                    </li>
                </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/todo/todo.js')}}"></script>
    <script src="{{url('plugins/photoswipe/photoswipe.min.js')}}"></script>
    <script src="{{url('plugins/photoswipe/photoswipe-ui-default.min.js')}}"></script>
    <script src="{{url('plugins/photoswipe/photoswipe.js')}}"></script>
    <script>
        var project_id = '{{$id}}';

        $("#add-milestone").click(function() {
            $.ajax({
                url: base_url+"/admin/add-milestone/"+project_id,
                method: 'post',
                data: {
                    'name' : $("#new-task").val()
                },
                success: function(data) {
                    $.ajax({
                        url: base_url+"/admin/read-milestone/"+project_id,
                        success: function(data) {
                            $("#todo-list").html(data.data);
                        }
                    });
                    $("#close-task-panel").trigger('click');
                }
            });
        });

        function updateMilestone(id, type) {
            $.ajax({
                url: base_url+"/admin/update-milestone/"+id+"/"+type
            });
        }
    </script>
@endsection