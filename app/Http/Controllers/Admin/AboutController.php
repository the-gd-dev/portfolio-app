<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AboutUser;
use App\Models\Profile;

class AboutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $data['title']      = 'About Me';
        $data['about']      = AboutUser::where('user_id', $userId)->first();
        $data['profiles']   = Profile::orderBy('profile')->get();
        return view('admin.about-me', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'about_summery' => 'max:1000',
            'work_profiles'  => 'required',
            'birthday'    => 'required',
            'age' => 'required|numeric|min:20|max:40'
        ]);
        $data = $request->except('skills', '_token');
        AboutUser::updateOrcreate(['user_id' => auth()->user()->id], $data);
        return response()->json($this->successResponse([], 'Succesfully Updated About Information'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileNameToStore = strtoupper(auth()->user()->username) . '-' . date('d-m-Y') . '-' . time() . '.' . $extension;
        $request->file('image')->storeAs('public/about-images', $fileNameToStore);
        $data['about_image'] = $fileNameToStore;
        AboutUser::updateOrcreate(['user_id' => auth()->user()->id], $data);
        return response()->json($this->successResponse(['url' => asset('storage/about-images/' . $fileNameToStore)], 'File uploaded successfull'), 200);
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
