<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
            <table class="table table-sm  ">
                <thead class="thead-blue">
                    <th style="width:1%;"><input type="checkbox" style="height: 16px; width: 16px;"
                            class="bulk-action all">
                    </th>
                    <th style="width:10%;">Name</th>
                    <th style="width:35%;">Username</th>
                    <th style="width:20%;">Email</th>
                    <th style="width:10%;">Status</th>
                    <th style="width:20%;">Actions</th>
                </thead>
                <tbody>
                    @if (isset($users) && $users->count() > 0)
                        @foreach ($users as $k => $user)
                            <tr>
                                <td><input value="{{ $user->id }}" class="bulk-action single" type="checkbox"
                                        style="height: 16px; width: 16px;"></td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <div class="row">
                                        @php
                                            $dp = asset('backend/img/undraw_profile.svg');
                                            if (isset($user->display_picture)) {
                                                $dp = asset('storage/display-pictures/' . $user->display_picture);
                                            }
                                        @endphp
                                        <div class="col-lg-1">
                                            <img class="rounded-circle border"
                                                style="width: 40px;height: 40px; object-fit : contain;"
                                                src="{{ $dp }}">
                                        </div>
                                        <div class="col-lg-10 pt-2" @if (strlen($user->username) > 25) data-toggle="tooltip" title="{{ $user->username }}" @endif>
                                            {{ substr($user->username, 0, 25) }}
                                            {{ strlen($user->username) > 25 ? '...' : '' }}</div>
                                    </div>
                                </td>
                                <td @if (strlen($user->username) > 25) data-toggle="tooltip" title="{{ $user->email }}" @endif>
                                    {{ substr($user->email, 0, 25) }}
                                    {{ strlen($user->email) > 25 ? '...' : '' }}
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input data-url="{{ route('admin.users.update', $user->id) }}" type="checkbox"
                                            @if ($user->is_active == '1') checked @endif class="custom-control-input active_status_cat"
                                            id="customSwitch{{ $user->id }}">
                                        <label class="custom-control-label"
                                            for="customSwitch{{ $user->id }}">{{ $user->is_active == '1' ? 'Active' : 'Inactive' }}</label>
                                        
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" data-id="{{ $user->secret_id ?? $user->id }}">
                                        <a class="btn btn-sm text-secondary btn__show"
                                            data-action="{{ route('profile.show', $user->secret_id ?? $user->id) }}"
                                            href="Javascript:void(0);"><i class="fa fa-eye"></i> Show </a>
                                        <a href="Javascript:void(0);"
                                            data-action="{{ route('admin.users.destroy', $user->secret_id ?? $user->id) }}"
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
