<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="thead-blue">
                <th>Profile</th>
                <th width="25">Icon</th>
                <th>Skill</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @if ($skills->count() > 0)
                    @foreach ($skills as $skill)
                        <tr >
                            <td class="text-capitalize">
                                <span class="capsule-shape">
                                    {{ $skill->profile->profile ?? '' }}
                                </span>
                            </td>
                            <td > 
                               <a 
                                  href="Javascript:void(0);" 
                                  data-toggle="tooltip" 
                                  title="change icon" 
                                  class="change-icon change-icon-{{$skill->id}}" 
                                  data-icon="{{$skill->icon}}" data-id="{{$skill->id}}"
                                  style="color: {{ (!empty($skill->background_color) && $skill->background_color != 'rgb(255, 255, 255)' ) ? $skill->background_color : 'current'}};"
                                >
                                   @if(!empty($skill->icon))
                                    <span class="icon-wrapper"><i class="{{ $skill->icon ?? '' }}"></i></span>
                                   @else
                                   <button type="button" data-toggle="tooltip" title="change icon"  class="btn btn-primary btn-sm">
                                        <i class="fa fa-box-open"></i>
                                   </button>
                                   
                                   @endif
                               </a>
                            </td>
                            <td class="text-capitalize">
                                <div class="d-flex">
                                    <span 
                                        class="capsule-shape capsule-shape-{{ $skill->id }}" 
                                        style="background-color: {{ $skill->background_color ?? 'transparent'}}; color : {{$skill->text_color ?? 'current' }} "
                                    > 
                                        {{ $skill->skill ?? '' }} 
                                    </span>
                                    <div class="d-flex ml-5">
                                        <div data-set-color="{{!empty($skill->background_color) ?  $skill->background_color : 'rgb(0, 0 ,0)'}}" data-target="{{ '.capsule-shape-'.$skill->id }}" class="bcPicker mr-2" data-toggle="tooltip" title="set background" style="height: 30px; width:30px;top:8px;"></div>
                                        <div data-set-color="{{!empty($skill->text_color) ?  $skill->text_color : 'rgb(0, 0 ,0)'}}" data-target="{{ '.capsule-shape-'.$skill->id }}" class="bcPicker2" data-toggle="tooltip" title="set text color"  style="height: 30px; width:30px;top:8px;"></div>
                                    </div>
                                </div>
                                {{-- <a href="Javascript:void(0);" data-toggle="tooltip" title="set colors"  style="position: relative;top:10px;"><i class="fa fa-edit"></i></a> --}}
                            </td>
                            <td>
                                <div class="btn-group" data-id="{{ $skill->id }}">
                                    <a class="btn btn-sm skill__edit" href="Javascript:void(0);"><i class="fa fa-pencil-alt"></i> Edit </a>
                                    <a href="Javascript:void(0);" data-action="{{route('admin.skills.destroy',$skill->id)}}" class=" btn btn-sm skill__delete"><i class="fa fa-trash"> Delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="3">
                        <div class="p-4">
                            No Skills Found <br>
                            <small class="text-muted">
                                Click &nbsp;
                                    <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#skillModal">
                                        + Create New
                                    </a>
                                &nbsp;
                                button to add new skills.
                            </small>
                        </div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
    </div>
    @if ($skills->count() > 0)
        <div class="col-sm-12">
            {{ $skills->links() }}
        </div>
    @endif
</div>
