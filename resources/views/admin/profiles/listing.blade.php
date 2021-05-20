<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
            <table class="table table-sm  ">
                <thead class="thead-blue">
                    <th width="30"><input type="checkbox" style="height: 16px; width: 16px;" class="bulk-action all"></th>
                    <th>Name</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @if (isset($profiles) && $profiles->count() > 0)
                        @foreach ($profiles as $profile)
                            <tr>
                                <td><input value="{{ $profile->id }}"  class="bulk-action single" type="checkbox" style="height: 16px; width: 16px;"></td>
                                <td class="text-capitalize">{{ $profile->profile ?? '' }}</td>
                                <td>
                                    <div class="btn-group" data-id="{{ $profile->id }}">
                                        <a class="btn btn-sm profile__edit" href="Javascript:void(0);"><i
                                                class="fa fa-pencil-alt"></i> Edit </a>
                                        <a href="Javascript:void(0);"
                                            data-action="{{ route('admin.profiles.destroy', $profile->id) }}"
                                            class=" btn btn-sm profile__delete"><i class="fa fa-trash"> Delete</i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">
                                <div class="p-4">
                                    No Profiles Found <br>
                                    <small class="text-muted">
                                        Click &nbsp;
                                        <a href="Javascript:void(0);" class="text-primary" data-toggle="modal"
                                            data-target="#profileModal">
                                            + Create New
                                        </a>
                                        &nbsp;
                                        button to add new profile.
                                    </small>
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    @if (isset($profiles) && $profiles->count() > 0)
        <div class="col-sm-12">
            {{ $profiles->links() }}
        </div>
    @endif
</div>
<script>
    $('[data-toggle="tooltip"]').tooltip();

</script>
