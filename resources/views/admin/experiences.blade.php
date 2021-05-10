@if ($resume->experiences->count() > 0)
    @foreach ($resume->experiences as $experience)
        <div class="card single-wrap qual-{{$experience->id}}">
            <div class="card-body">
                <table class="table-sm">
                    <tr>
                        <td>Position</td>
                        <td colspan="3" data-id="{{$experience->id}}">
                            <input  type="text"  class="form-control position" value="{{$experience->position ?? ''}}" />
                        </td>
                    </tr>
                    <tr>
                        <td>From</td>
                        <td data-id="{{$experience->id}}">
                            <input  type="date"  value="{{$experience->from_date ?? ''}}" class="form-control from_date_ex" />
                        </td>
                        <td>To</td>
                        <td data-id="{{$experience->id}}">
                            <input  type="date"  value="{{$experience->to_date ?? ''}}"  class="form-control to_date_ex" />
                        </td>
                    </tr>
                    <tr>
                        <td>Company Name</td>
                        <td colspan="3" data-id="{{$experience->id}}">
                            <input  type="text" value="{{$experience->company_name ?? ''}}"   class="form-control company_name" />
                        </td>
                    </tr>
                    <tr>
                        <td>Company Address</td>
                        <td colspan="3" data-id="{{$experience->id}}">
                            <textarea   class="form-control company_address">{!! $experience->company_address !!}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Responsibilities</td>
                        <td colspan="3" data-id="{{$experience->id}}" >
                            <textarea   class="form-control responsibilities">{!! $experience->responsibilities !!}</textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="d-flex justify-content-end data-status">
                <span class="saving" style="display: none;" >
                    <div class="spinner-border spinner-border-sm" style="position: relative; top:-2px"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div> Saving
                </span>
                <span class="saved" style="display: none;">
                    <i class="fa fa-check-circle"></i>
                    Saved
                </span>
                <a href="Javascript:void(0);" 
                   data-id="{{$experience->id}}" 
                   class="btn btn-sm mb-1 delete-experience"><i
                   class="fa fa-trash"></i> 
                    Remove This Row
                </a>
            </div>
        </div>
    @endforeach
    @else
    <div class="row">
        <div class="col-sm-12 p-4">
            <h6>No experiences added</h6>
            <small>Click button below to add.</small>
        </div>
    </div>
@endif
