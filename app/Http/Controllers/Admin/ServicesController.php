<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    protected $services;
    protected $perpage = 10;
    public function __construct(Service $services)
    {
        $this->services = $services;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->handleAjax($request);
        }
        $data['title']    = 'Services Management ';
        return view('admin.services.index', $data);
    }

    protected function getView($forAjax = null)
    {

        $data['services'] =   $this->services->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.services.listing' : 'admin.services.index';
        return view($view, $data);
    }
    public function handleAjax($request)
    {
        $query = $this->services;
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('service', 'like', "$search%");
        }
        $data['services'] =  $query->paginate($this->perpage);
        return  ['appendHtml' => view('admin.services.listing', $data)->render()];
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
        $id = $request->service_id ?? null;
        $request->validate([
            'service' => 'required|unique:services,service,' . $id . ',id'
        ]);


        $dbData = $request->all();
        $dbData['user_id'] = auth()->user()->id;
        $message = !empty($id) ? 'Successfully updated service.' : 'Successfully created  service.';
        $this->services->updateOrCreate(['id' => $id, 'user_id' => auth()->user()->id], $dbData);
        $data['appendHtml'] =  $this->getView('ajax')->render();
        return $this->successResponse($data, $message);
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
        try {
            $service = $this->services->find($id);
            if (!isset($service)) {
                return response()->json(['message' => 'No Services Found.'], 404);
            }
            return response()->json(['service' => $service], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
        return $this->services
            ->updateOrCreate(['id' => $id], $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $service = $this->services->find($id);
            if (!isset($service)) {
                return response()->json(['message' => 'No portfolio service Found.'], 404);
            }
            $isDeleted = $service->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted service.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                return $this->successResponse($data, $message);
            }
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
    public function setColors(Request $request)
    {
        $id = $request->skill_id ?? null;
        $skill = $this->services->find($id);
        if (!$skill) {
            return response()->json(404);
        }
        if ($request->has('text_color')) {
            $skill->update(['text_color' => trim($request->text_color)]);
        }
        if ($request->has('background_color')) {
            $skill->update(['background_color' => trim($request->background_color)]);
        }
        //return $this->successResponse([], 'Icon set successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveIcon(Request $request)
    {
        $id = $request->skill_id ?? null;
        $skill = $this->services->find($id);
        if (!$skill) {
            return response()->json(404);
        }
        $skill->update(['icon' => trim($request->icon)]);
        return $this->successResponse([], 'Icon set successfully.');
    }
    /**
     * Updating Settings
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->except('hide_service');
        Setting::updateOrCreate(['setting' => 'hide_portfolio', 'page' => 'service', 'user_id' => $user_id], [
            'value' => isset($request->hide_service) ? '1' : '0',
            'setting' => 'hide_service',
            'user_id' => $user_id,
            'page' => 'service',
            'is_apply' => '1'
        ]);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['setting' => $key, 'page' => 'service',  'user_id' => $user_id], [
                'value' => $value['value'],
                'user_id' => $user_id,
                'page' => 'service',
                'setting' => $key,
                'is_apply' => isset($value['apply']) ? '1' : '0'
            ]);
        }
        $message = 'Successfully updated service settings.';
        $response = $this->successResponse([], $message);
        return response()->json($response, 200);
    }
    /**
     * Fetch Settings
     * @return \Illuminate\Http\Response
     */
    public function getServicesSettings()
    {
        $user_id = auth()->user()->id;
        $responseData  = [];
        $responseData = $this->getSettings($user_id, 'service', 'true');
        return response()->json(['data' => $responseData], 200);
    }
}
