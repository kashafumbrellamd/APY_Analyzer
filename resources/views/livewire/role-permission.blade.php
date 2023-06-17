<!-- <div>
    <div class="container"></div>
</div> -->
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="row mb-4">
            <div class="col-md-8" >
                <!-- <select class="form-select form-control" aria-label="Default select example" wire:model="role_id">
                    <option value="">Select Role</option>
                    @foreach($rolls as $roll)
                        @if($roll->id == $role_id)
                            <option selected value="{{$roll->id}}">{{$roll->name}}</option>
                        @else
                            <option value="{{$roll->id}}">{{$roll->name}}</option>
                        @endif
                    @endforeach
                </select> -->
                <input type="text" class="form-control" wire:model="role_id" placeholder="Enter New Role...." >
                <div>role: {{ $role_id }}</div>
            </div>
            <div class="col-md-2">
                <!-- <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button> -->
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row-flex">
                    <form method="post" action="/Tests/Post/">      
                        <fieldset>      
                            <legend>What is Your Favorite Pet?</legend>
                            @foreach($permissions as $permission)
                            @if($role_id == $permission->roll_id)
                            <input checked type="checkbox" name="{{$permission->slug}}" value="{{$permission->id}}">{{$permission->name}}<br>
                            @else
                            <input type="checkbox" name="{{$permission->slug}}" value="{{$permission->id}}">{{$permission->name}}<br>
                            @endif
                            @endforeach     
                            <br>      
                            <input type="submit" value="Submit now" />      
                        </fieldset>      
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
