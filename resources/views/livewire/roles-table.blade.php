<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="row mb-4">
            <div class="col-md-10" >
                <input type="text" class="form-control" wire:model.lazy="role" placeholder="Enter New Role...." >
            </div>
            <div class="col-md-2">
                <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $dt->id }}</td>
                                <td>{{ $dt->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
