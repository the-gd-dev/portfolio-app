<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\EducationTrait;
use App\Http\Traits\ExperienceTrait;
use App\Models\Resume;
use Illuminate\Http\Request;

class ResumesController extends Controller
{
    use EducationTrait, ExperienceTrait;
    protected $resume;
    protected $perpage = 10;
    public function __construct(Resume $resume)
    {
        $this->resume = $resume;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $data['title']    =  'About Me';
        $data['resume']   =  $this->resume->with('qualifications', 'experiences')
                                  ->where('user_id', $userId)->first();
        return view('admin.resume', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->resume
                ->where('user_id', auth()->user()->id)
                ->update([
                    'resume_summery' => $request->resume_summery,
                    'show_section' => $request->Has('show_section') ? '1' : '0'
                ]);
            $message = 'Successfully updated resume.';
            return $this->successResponse([], $message);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
