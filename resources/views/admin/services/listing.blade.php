<div class="row justify-content-start">
    <div class="col-sm-12">
        <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="thead-blue">
                <th width="60">Icon</th>
                <th width="400">Service</th>
                <th>Service Description</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @if (isset($services) && $services->count() > 0)
                    @foreach ($services as $k => $service)
                        <tr >
                            <td > 
                               <a 
                                  href="Javascript:void(0);" 
                                  data-toggle="tooltip" 
                                  title="change icon" 
                                  class="change-icon change-icon-{{$service->id}}" 
                                  data-icon="{{$service->icon}}" data-id="{{$service->id}}"
                                  style="color: {{ (!empty($service->background_color) && $service->background_color != 'rgb(255, 255, 255)' ) ? $service->background_color : 'current'}};"
                                >
                                   @if(!empty($service->icon))
                                    <span class="icon-wrapper"><i class="{{ $service->icon ?? '' }}"></i></span>
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
                                        class="capsule-shape capsule-shape-{{ $service->id }}" 
                                        style="background-color: {{ $service->background_color ?? 'transparent'}}; color : {{$service->text_color ?? 'current' }} "
                                    > 
                                        {{ $service->service ?? '' }} 
                                    </span>
                                    <div class="d-flex ml-5 bc-container">
                                        <div  data-set-color="{{!empty($service->background_color) ?  $service->background_color : 'rgb(0, 0 ,0)'}}" data-target="{{ '.capsule-shape-'.$service->id }}" class="bcPicker mr-2" data-toggle="tooltip" title="set background" style="height: 30px; width:30px;top:8px;"></div>
                                        <div  data-set-color="{{!empty($service->text_color) ?  $service->text_color : 'rgb(0, 0 ,0)'}}" data-target="{{ '.capsule-shape-'.$service->id }}" class="bcPicker2" data-toggle="tooltip" title="set text color"  style="height: 30px; width:30px;top:8px;"></div>
                                    </div>
                                </div>
                                {{-- <a href="Javascript:void(0);" data-toggle="tooltip" title="set colors"  style="position: relative;top:10px;"><i class="fa fa-edit"></i></a> --}}
                            </td>
                            <td> {{ $service->service_description ?? '' }} </td>
                            <td>
                                <div class="btn-group" data-id="{{ $service->id }}">
                                    <a class="btn btn-sm skill__edit" href="Javascript:void(0);"><i class="fa fa-pencil-alt"></i> Edit </a>
                                    <a href="Javascript:void(0);" data-action="{{route('admin.services.destroy',$service->id)}}" class=" btn btn-sm skill__delete"><i class="fa fa-trash"> Delete</i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="4">
                        <div class="p-4">
                            <strong>No Services Found </strong>
                            <br>
                            <small class="text-muted">
                                Click &nbsp;
                                    <a href="Javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#skillModal">
                                        + Create New
                                    </a>
                                &nbsp;
                                button to add new services.
                            </small>
                        </div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
    </div>
    @if (isset($services) && $services->count() > 0)
        <div class="col-sm-12">
            {{ $services->links() }}
        </div>
    @endif
</div>
<script>
    $(document).ready(function() {
        $('.bcPicker').bcPicker();
        $('.bcPicker2').bcPicker();
    });
</script>