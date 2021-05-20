@if ($resume->qualifications->count() > 0)
    @foreach ($resume->qualifications as $education)
        <div class="card single-wrap ed-{{$education->id}}">
            <div class="card-body">
                <table class="table-sm  w-100">
                    <tr>
                        <td>Institute</td>
                        <td colspan="4" data-id="{{$education->id}}">
                            <input  type="text" value="{{$education->institute ?? ''}}" class="form-control institute" />
                        </td>
                    </tr>
                    <tr>
                        <td>Course</td>
                        <td colspan="4" data-id="{{$education->id}}">
                            <input  type="text" value="{{$education->course ?? ''}}" class="form-control course" />
                        </td>
                    </tr>
                    <tr>
                        <td>Duration </td>
                        @php
                            $fromDate = null;
                            $toDate = null;
                            if(!empty($education->from_date)){ $fromDate = date('Y-m-d', strtotime($education->from_date));  }
                            if(!empty($education->to_date)){ $toDate = date('Y-m-d', strtotime($education->to_date));  }
                        @endphp
                        <td data-id="{{$education->id}}">
                            <input  type="date" data-id="{{$education->id}}" value="{{ $fromDate ?? ''}}" class="form-control from_date" />
                        </td>
                        <td>To</td>
                        <td data-id="{{$education->id}}">
                            <input  type="date" data-id="{{$education->id}}"  value="{{ $toDate ?? ''}}"  class="form-control to_date" />
                        </td>
                    </tr>
                    <tr>
                        <td>Course Description</td>
                        <td colspan="4" data-id="{{$education->id}}" >
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
                <label class="mt-1" data-id="{{$education->id}}">
                    show <input type="checkbox" value="1"  class="is_shown" @if($education->is_shown == '1') checked  @endif>
                </label>
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
