<?php
namespace App\Http\Traits;
use App\Models\Education;
use Illuminate\Http\Request;
trait EducationTrait
{
    public function addQualifications(Request $request)
    {
        $userId = auth()->user()->id;
        $resume_id = $request->resume_id;
        $education = Education::create(['user_id'=> $userId ,'resume_id' => intval($resume_id)]);
        $resume = $this->resume->with('qualifications')->where('user_id', $userId)->first();
        $data['appendHtml']  = view('admin.qualifications',compact('resume'))->render();
        return $data;
    }

    public function saveQualifications(Request $request)
    {
        //
    }
    public function deleteQualifications(Request $request)
    {
        //
    }
}