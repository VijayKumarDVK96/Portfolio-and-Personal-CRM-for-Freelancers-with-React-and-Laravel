@foreach ($projects as $value)
    <div class="col-xl-4 col-lg-6">
        <div class="project-box">
            @if($value->status == 0)
            <span class="badge badge-warning">Pending</span>
            @elseif($value->status == 1)
            <span class="badge badge-success">Done</span>
            @endif

            <a href="{{url('admin/project-details', $value->id)}}"><h6>{{$value->name}}</h6></a>
            <div class="media">
                <div class="media-body">
                    <p>{{$value->client->full_name}}</p>
                </div>
            </div>
            <div class="project-status mt-4">
                <div class="row details">
                    <div class="col-6"><span>Open Tasks </span></div>
                    <div class="col-6 text-primary">{{$value->pending_tasks_count}} </div>
                    <div class="col-6"> <span>Completed Tasks</span></div>
                    <div class="col-6 text-primary">{{$value->completed_tasks_count}}</div>
                    <div class="col-6"> <span>Started At</span></div>
                    <div class="col-6 text-primary">{{date('d-m-Y', strtotime($value->created_at))}}</div>
                    <div class="col-6"> <span>Deadline</span></div>
                    <div class="col-6 text-primary">{{date('d-m-Y', strtotime($value->deadline))}}</div>
                </div>
                <div class="media mb-0 mt-2">
                    <p> @if($value->pending_tasks_count == 0 && $value->completed_tasks_count == $value->project_tasks_count) 100 @else {{round($value->completed_tasks_count*100/$value->project_tasks_count)}} @endif%</p>
                    <div class="media-body text-right"><span>Task Completed</span></div>
                </div>
                <div class="progress" style="height: 5px">

                    <div class="progress-bar-animated @if($value->status == 0){{'bg-primary'}}@elseif($value->status == 1){{'bg-success'}} @endif progress-bar-striped"
                        role="progressbar" style="width: @if($value->pending_tasks_count == 0 && $value->completed_tasks_count == $value->project_tasks_count) 100% @else {{round($value->completed_tasks_count*100/$value->project_tasks_count)}}% @endif" aria-valuenow="10" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>

                <div class="media mb-0 mt-2">
                    <p> @if($value->pending_milestones_count == 0 && $value->completed_milestones_count == $value->project_milestones_count) 100 @else {{round($value->completed_milestones_count*100/$value->project_milestones_count)}} @endif%</p>
                    <div class="media-body text-right"><span>Milestones Completed</span></div>
                </div>
                <div class="progress" style="height: 5px">
                    <div class="progress-bar-animated @if($value->status == 0){{'bg-info'}}@elseif($value->status == 1){{'bg-success'}} @endif progress-bar-striped"
                        role="progressbar" style="width: @if($value->pending_milestones_count == 0 && $value->completed_milestones_count == $value->project_milestones_count) 100% @else {{round($value->completed_milestones_count*100/$value->project_milestones_count)}}% @endif" aria-valuenow="10" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach