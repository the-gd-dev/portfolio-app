<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="thead-blue">
                <th>Name</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @if ($profiles->count() > 0)
                    @foreach ($profiles as $profile)
                        <tr >
                            <td class="text-capitalize">{{ $profile->profile ?? '' }}</td>
                            <td>
                                <div class="btn-group" data-id="{{ $profile->id }}">
                                    <a class="btn btn-sm profile__edit" href="Javascript:void(0);"><i class="fa fa-pencil-alt"></i> Edit </a>
                                    <a href="Javascript:void(0);" data-action="{{route('admin.profiles.destroy',$profile->id)}}" class=" btn btn-sm profile__delete"><i class="fa fa-trash"> Delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="2">
                        <div class="p-4">
                            No Profiles Found <br>
                            <small class="text-muted">
                                Click &nbsp;
                                    <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#profileModal">
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
    @if ($profiles->count() > 0)
        <div class="col-sm-12">
            {{ $profiles->links() }}
        </div>
    @endif
</div>
