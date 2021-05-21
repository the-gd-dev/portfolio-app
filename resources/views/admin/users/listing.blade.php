<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
            <table class="table table-sm  ">
                <thead class="thead-blue">
                    <th width="30"><input type="checkbox" style="height: 16px; width: 16px;" class="bulk-action all"></th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @if (isset($users) && $users->count() > 0)
                        @foreach ($users as $k => $user)
                            <tr>
                                <td><input value="{{ $user->id }}"  class="bulk-action single" type="checkbox" style="height: 16px; width: 16px;"></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="custom-control custom-switch" >
                                        <input data-url="{{route('admin.users.update', $user->id)}}" type="checkbox" @if( $user->is_active == '1') checked @endif class="custom-control-input active_status_cat" id="customSwitch{{$user->id}}">
                                        <label class="custom-control-label" for="customSwitch{{$user->id}}">{{ $user->is_active == '1' ? 'Active' : 'Inactive'}}</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" data-id="{{ $user->secret_id ?? $user->id }}">
                                        <a href="Javascript:void(0);"
                                            data-action="{{ route('admin.users.destroy', ($user->secret_id ?? $user->id)) }}"
                                            class=" btn btn-sm user__delete"><i class="fa fa-trash"> Delete</i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <div class="p-4">
                                    <strong>No users found. </strong>
                                    <br>
                                    <small class="text-muted">
                                        Click &nbsp;
                                        <a href="Javascript:void(0);" class="text-primary" data-toggle="modal"
                                            data-target="#skillModal">
                                            + Create New
                                        </a>
                                        &nbsp;
                                        button to add new users.
                                    </small>
                                    
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    @if (isset($users) && $users->count() > 0)
        <div class="col-sm-12">
            {{ $users->links() }}
        </div>
    @endif
</div>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
