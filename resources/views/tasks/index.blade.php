@extends('layouts/app')

@section('title')
    Todos Lists
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">


        <div class="row g-4 mb-4">
            <div class="col-sm-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Total Tasks</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $totalTasks }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-spreadsheet bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Completed Tasks</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $completedTasks }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-spreadsheet bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Incomplete Tasks</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ $IncompletedTasks }}</h4>
                                </div>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-spreadsheet bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    <div class="col-md-4">
                        <h5 class="card-title">Search Filter</h5>
                    </div>
                    <div class="col-md-4">
                        <select id="complete_filter" class="form-select text-capitalize">
                            <option value=""> Select Status </option>
                            <option value="completed" class="text-capitalize">Completed</option>
                            <option value="incompleted" class="text-capitalize">Incomplete</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row my-3">
                        <div class="col-md-2">
                            <h5 class="card-title">Tasks List</h5>
                        </div>
                        <div class="col-md-10">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                <div class="dt-buttons"><button class="dt-button add-new btn btn-primary" tabindex="0"
                                        aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasAddTask"><span><i
                                                class="bx bx-plus me-0 me-sm-1"></i><span
                                                class="d-none d-sm-inline-block">Add New Task</span></span></button> </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="datatables-tasks table border-top">
                            <thead>
                                <tr>
                                    <th>Task Id</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @include('partials.modals.add_tasks')
        </div>
    </div>
    <!-- / Content -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $("#addNewTaskForm").validate({
                rules: {
                    title: "required",
                },
                messages: {
                    title: {
                        required: "Task Title is required",
                    },
                },

            });

            var taskTable = $('.datatables-tasks').DataTable({

                filter: true,
                processing: true,
                serverSide: false,
                responsive: true,
                lengthChange: false,

                ajax: {
                    url: "{{ route('tasks.index') }}",
                    data: function(d) {
                        d.completed = $('#complete_filter').val();
                    }
                },

                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],

            });

            $('.add-new').click(function() {
                $('#offcanvasAddTaskLabel').text('Add Task');
                $('[name="task_id"]').val(null);
                $('[name="title"]').val(null);
                $('[name="description"]').val(null);
            })

            $('.datatables-tasks').on('click', '.edit-task', function() {
                var taskId = $(this).attr("data-id");
                $.ajax({
                    type: 'get',
                    url: "/tasks/" + taskId + "/edit",
                    success: function(response) {
                        let task = response.task;
                        $('#offcanvasAddTaskLabel').text('Edit Task');
                        $('[name="task_id"]').val(task.id);
                        $('[name="title"]').val(task.title);
                        $('[name="description"]').val(task.description);
                    }
                });
            });

            $('.datatables-tasks').on('click', '.delete-task', function() {
                var taskId = $(this).attr("data-id");
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this task!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            let token = "{{ csrf_token() }}";
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': token
                                }
                            });

                            $.ajax({
                                type: 'DELETE',
                                url: "/tasks/" + taskId,
                                success: function(response) {
                                    taskTable.ajax.reload();
                                    swal("Success", "Task Deleted Successfully!",
                                        "success");
                                },
                                error: function(error) {
                                    swal("Error", "Failed to Task Delete!", "error");
                                }

                            });
                        } else {
                            swal("Your task is safe!");
                        }
                    });
            });

            $('.datatables-tasks').on('change', '.complete-task', function() {
                let taskId = $(this).attr("data-id");
                let token = "{{ csrf_token() }}";
                let completed = $(this).prop('checked') ? 1 : 0;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                $.ajax({
                    type: 'PUT',
                    data: {
                        completed: completed
                    },
                    url: "/tasks/" + taskId,
                    success: function(response) {
                        taskTable.ajax.reload();
                        swal("Success", "Task has been Updated Successfully!",
                            "success");
                    }
                });
            });

            $('#complete_filter').change(function() {
                taskTable.ajax.reload();
            })

        });
    </script>
@endpush
