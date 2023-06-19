<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Select Permissions for this Role</h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <select class="form-select form-control" aria-label="Default select example"
                        wire:change="onrollselect($event.target.value)">
                        <option value="0">Select Role</option>
                        @foreach ($rolls as $roll)
                            @if ($roll->id == $role_id)
                                <option selected value="{{ $roll->id }}">{{ $roll->name }}</option>
                            @else
                                <option value="{{ $roll->id }}">{{ $roll->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <div class="row-flex">
                    <form wire:submit.prevent="submitForm">
                        <fieldset>
                            <legend>Assigned permissions to this role</legend>
                            @foreach ($permissions as $permission)
                                <input type="checkbox" name="{{ $permission->slug }}" value="{{ $permission->id }}"
                                    wire:model.defer="selectedOptions"> {{ $permission->name }}<br>
                            @endforeach
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
