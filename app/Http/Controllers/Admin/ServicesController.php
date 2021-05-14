<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
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
        return $this->getView();
    }

    protected function getView($forAjax = null){
        $data['title']    = 'Services Management ';
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
        $data['appendHtml'] = view('admin.services.listing', $data)->render();
        return $data;
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
            'service' =>'required|unique:services'
        ]);
        $id = $request->category_id ?? null;
        $dbData = $request->all();
        $dbData['user_id'] = auth()->user()->id;
        $message = !empty($id) ? 'Successfully updated portfolio service.' : 'Successfully created portfolio service.';
        $this->services->updateOrCreate(['id' => $id, 'user_id' =>auth()->user()->id ],$dbData);
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
        return $this->services
                    ->updateOrCreate(['id' => $id],$request->all());
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
            $portfolio_category = $this->services->find($id);
            if (!isset($portfolio_category)) {
                return response()->json(['message' => 'No portfolio service Found.'], 404);
            }
            $isDeleted = $portfolio_category->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted service.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
