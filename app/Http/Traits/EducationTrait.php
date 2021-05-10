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
        try {
            $id = $request->education_id;
            $message = 'Successfully saved education.';
            $edu = Education::find($id);
            if(!$edu) { return response()->json(['message' => 'Resource Not Found.'],404);}
            $edu->update($request->except('education_id'));
            return $this->successResponse([], $message);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
        
    }
    public function deleteQualifications(Request $request)
    {
        try {
            $education = Education::find($request->education_id);
            if(!isset($education)){ return response()->json(['message' => 'No Education Found.'],404); }
            $isDeleted = $education->delete();
            if($isDeleted){
                $message = 'Successfully deleted education.';
                return $this->successResponse([], $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}