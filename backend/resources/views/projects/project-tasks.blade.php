@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/todo/todo.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                <h5>Tasks</h5>
                </div>
                <div class="card-body">
                    <div class="todo">
                        <div class="todo-list-wrapper">
                            <div class="todo-list-container">
                                <div class="todo-list-body">
                                    <ul id="todo-list">
                                        @foreach ($tasks as $value)
                                            @if($value->status == 1)
                                            <li class="task completed">
                                            @else
                                            <li class="task">
                                            @endif
                                            
                                            <div class="task-container">
                                                <h4 class="task-label">{{$value->name}} </h4>
                                                <span class="task-action-btn">
                                                    <span class="action-box large delete-btn" title="Delete Task" onclick="updateTask({{$value->id}}, 'delete')"><i class="icon"><i class="fa fa-times-circle"></i></i></span>
                                                
                                                    <span class="action-box large complete-btn" title="Mark Complete" onclick="updateTask({{$value->id}}, 'update')"><i class="icon"><i class="fa fa-check-square"></i></i></span>
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
                                        <span class="btn btn-success ml-3 add-new-task-btn" id="add-task">
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
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/todo/todo.js')}}"></script>

    <script>
        var project_id = '{{$id}}';

        $("#add-task").click(function() {
            $.ajax({
                url: base_url+"/admin/add-task/"+project_id,
                method: 'post',
                data: {
                    'name' : $("#new-task").val()
                },
                success: function(data) {
                }
            });
        });

        function updateTask(id, type) {
            $.ajax({
                url: base_url+"/admin/update-task/"+id+"/"+type
            });
        }
    </script>
@endsection