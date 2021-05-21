<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="custom-table-responsive">
        <table class="table table-sm  ">
            @php
                $is_superadmin =  auth()->user()->role_id == 1;
            @endphp
            <thead class="thead-blue">
                <th width="30"><input type="checkbox" style="height: 16px; width: 16px;" class="bulk-action all"></th>
                <th>Name</th>
                @if ($is_superadmin )
                    <th>CreatedBy</th>
                @endif
                <th>Category</th>
                <th width="400">Portfolio Description</th>
                <th>Link</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @if (isset($portfolios) && $portfolios->count() > 0)
                    
                    @foreach ($portfolios as $portfolio)
                        <tr >
                            <td><input value="{{ $portfolio->id }}"  class="bulk-action single" type="checkbox" style="height: 16px; width: 16px;"></td>
                            <td class="text-capitalize">{{ $portfolio->name ?? '' }}</td>
                            @if ($is_superadmin )
                                <td>{{ $portfolio->user->name }}</td>
                            @endif
                            <td class="text-capitalize">{{ $portfolio->category->name ?? '' }}</td>
                            <td class="text-capitalize">{!! $portfolio->description !!} {{strlen($portfolio->description) > 100 ? '...' : ''}}</td>
                            <td class="text-capitalize"><a href="Javascript:void(0);" class="link__show" data-action="{{ $portfolio->link ?? '' }}">{{ $portfolio->name ?? '' }}</a> </td>
                            <td>
                                <div class="btn-group" data-id="{{ $portfolio->id }}">
                                    <a class="btn btn-sm text-secondary btn__show" data-action="{{route('project.show',$portfolio->id)}}" href="Javascript:void(0);"><i class="fa fa-eye"></i> Show </a>
                                    <a class="btn btn-sm text-secondary" href="{{route('admin.portfolios.edit',$portfolio->id)}}"><i class="fa fa-pencil-alt"></i> Edit </a>
                                    <a href="Javascript:void(0);" data-action="{{route('admin.portfolios.destroy',$portfolio->id)}}" class=" btn btn-sm portfolio__delete text-secondary"><i class="fa fa-trash"> Delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="6">
                        <div class="p-4">
                            No Portfolios Found <br>
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
    @if ( isset($portfolios) &&  $portfolios->count() > 0)
        <div class="col-sm-12">
            {{ $portfolios->links() }}
        </div>
    @endif
</div>
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>

