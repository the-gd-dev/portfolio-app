<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
        <table class="table table-sm  ">
            <thead class="thead-blue">
                <th width="30"><input type="checkbox" style="height: 16px; width: 16px;" class="bulk-action all"></th>
                <th>Name</th>
                <th width="150">Active Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @if (isset($categories) && $categories->count() > 0)
                    @foreach ($categories as $cat)
                        <tr >
                            <td><input value="{{ $cat->id }}"  class="bulk-action single" type="checkbox" style="height: 16px; width: 16px;"></td>
                            <td class="text-capitalize">{{ $cat->name ?? '' }}</td>
                            <td>
                                <div class="custom-control custom-switch" >
                                    <input data-url="{{route('admin.portfolio-categories.update', $cat->id)}}" type="checkbox" @if( $cat->is_active == '1') checked @endif class="custom-control-input active_status_cat" id="customSwitch{{$cat->id}}">
                                    <label class="custom-control-label" for="customSwitch{{$cat->id}}">{{ $cat->is_active == '1' ? 'Active' : 'Inactive'}}</label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" data-id="{{ $cat->id }}">
                                    
                                    <a class="btn btn-sm cat__edit" href="Javascript:void(0);"><i class="fa fa-pencil-alt"></i> Edit </a>
                                    <a href="Javascript:void(0);" data-action="{{route('admin.portfolio-categories.destroy',$cat->id)}}" class=" btn btn-sm cat__delete"><i class="fa fa-trash"> Delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="4">
                        <div class="p-4">
                            No Portfolio Categories Found <br>
                            <small class="text-muted">
                                Click &nbsp;
                                    <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#profileModal">
                                        + Create New
                                    </a>
                                &nbsp;
                                button to add portfolio category.
                            </small>
                        </div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
    </div>
    @if (isset($categories) && $categories->count() > 0)
        <div class="col-sm-12">
            {{ $categories->links() }}
        </div>
    @endif
</div>
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>

