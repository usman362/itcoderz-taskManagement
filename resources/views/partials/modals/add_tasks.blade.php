<!-- Offcanvas to add new user -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddTask" aria-labelledby="offcanvasAddTaskLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddTaskLabel" class="offcanvas-title">Add Task</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
        <form action="{{route('tasks.store')}}" method="POST" class="add-new-task pt-0" id="addNewTaskForm" >
            @csrf
            <input type="hidden" name="task_id">
            <div class="mb-3">
                <label class="form-label" for="title">Task Title</label>
                <input type="text" class="form-control" id="title" name="title"/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-control" id="" cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
