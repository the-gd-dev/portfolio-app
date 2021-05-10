@if ($resume->qualifications->count() > 0)
    @foreach ($resume->qualifications as $education)
        <div class="card single-wrap ed-{{$education->id}}">
            <div class="card-body">
                <table class="table-sm">
                    <tr>
                        <td>Institute</td>
                        <td colspan="3" data-id="{{$education->id}}">
                            <input  type="text" value="{{$education->institute ?? ''}}" class="form-control institute" />
                        </td>
                    </tr>
                    <tr>
                        <td>Course</td>
                        <td colspan="3" data-id="{{$education->id}}">
                            <input  type="text" value="{{$education->course ?? ''}}" class="form-control course" />
                        </td>
                    </tr>
                    <tr>
                        <td>Duration </td>
                        <td data-id="{{$education->id}}">
                            <input  type="date" data-id="{{$education->id}}" value="{{$education->from_date ?? ''}}" class="form-control from_date" />
                        </td>
                        <td>To</td>
                        <td data-id="{{$education->id}}">
                            <input  type="date" data-id="{{$education->id}}"  value="{{$education->to_date ?? ''}}"  class="form-control to_date" />
                        </td>
                    </tr>
                    <tr>
                        <td>Course Description</td>
                        <td colspan="3" data-id="{{$education->id}}" >
                            <textarea   class="form-control course_description">{!! $education->course_description ?? '' !!}</textarea>
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
                   data-id="{{$education->id}}" 
                   class="btn btn-sm mb-1 delete-education"><i
                   class="fa fa-trash"></i> 
                    Remove This Row
                </a>
            </div>
        </div>
    @endforeach
    @else
    <div class="row">
        <div class="col-sm-12 p-4">
            <h6>No qualifications added</h6>
            <small>Click button below to add.</small>
        </div>
    </div>
@endif
