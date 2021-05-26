<?php
namespace App\Http\Traits;
use App\Models\Experience;
use Illuminate\Http\Request;
trait ExperienceTrait
{
    public function addExperiences(Request $request)
    {
        $userId = auth()->user()->id;
        $resume_id = $request->resume_id;
        $experience = Experience::create(['user_id'=> $userId ,'resume_id' => intval($resume_id)]);
        $resume = $this->resume->with('experiences')->where('user_id', $userId)->first();
        $data['appendHtml']  = view('admin.experiences',compact('resume'))->render();
        $this->createActivity(auth()->user(), 'experiences', 'store', $request->all());
        return $data;
    }
    public function saveExperiences(Request $request)
    {
        try {
            $id = $request->experience_id;
            $message = 'Successfully saved experience.';
            $edu = Experience::find($id);
            if(!$edu) { return response()->json(['message' => 'Resource Not Found.'],404);}
            $edu->update($request->except('experience_id'));
            return $this->successResponse([], $message);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function removeExperiences(Request $request)
    {
        try {
            $experience = Experience::find($request->experience_id);
            if(!isset($experience)){ return response()->json(['message' => 'No Experience Found.'],404); }
            $isDeleted = $experience->delete();
            if($isDeleted){
                $message = 'Successfully deleted experience.';
                $this->createActivity(auth()->user(), 'experiences', 'delete', $request->all());
                return $this->successResponse([], $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}