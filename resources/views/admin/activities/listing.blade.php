<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
        <table class="table table-sm  ">
            <thead class="thead-blue">
                @if(auth()->user()->role_id == 1)
                    <th width="30"><input type="checkbox" style="height: 16px; width: 16px;" class="bulk-action all"></th>
                @endif
                <th>Activitiy</th>
                @if(auth()->user()->role_id == 1)
                    <th>User</th>
                    <th>Actions</th>
                    <th>Recorded On</th>
                @else
                    <th>Recorded On</th>
                @endif
            </thead>
            <tbody>
                @if (isset($activities) && $activities->count() > 0)
                    @foreach ($activities as $act)
                        <tr >
                            @if(auth()->user()->role_id == 1)
                                <td><input value="{{ $act->id }}"  class="bulk-action single" type="checkbox" style="height: 16px; width: 16px;"></td>
                            @endif
                            <td class="text-capitalize">{{ str_replace('_',' ',$act->activity) ?? '' }}</td>
                            @if(auth()->user()->role_id == 1)
                            <td class="text-capitalize">{{ $act->user->name ?? '' }}</td>
                            <td>
                                <div class="btn-group" data-id="{{ $act->id }}">
                                    <a class="btn btn-sm cat__edit" href="Javascript:void(0);"><i class="fa fa-pencil-alt"></i> Edit </a>
                                    <a href="Javascript:void(0);" data-action="{{route('activities.destroy',$act->id)}}" class=" btn btn-sm cat__delete"><i class="fa fa-trash"> Delete</i></a>
                                </div>
                            </td>
                            <td class="text-capitalize">{{ date('M d Y h:i A', strtotime($act->created_at)) ?? '' }}</td>
                            @else
                                <td class="text-capitalize">{{ date('M d Y h:i A', strtotime($act->created_at)) ?? '' }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="4">
                        <div class="p-4">
                            No Activities Found <br>
                            <small class="text-muted">
                                Here only you can see your activities on the application.
                            </small>
                        </div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
    </div>
    @if (isset($activities) && $activities->count() > 0)
        <div class="col-sm-12">
            {{ $activities->links() }}
        </div>
    @endif
</div>
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>

