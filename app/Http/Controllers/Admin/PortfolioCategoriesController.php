<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;

class PortfolioCategoriesController extends Controller
{
    protected $portfolio_categories;
    protected $perpage = 10;
    public function __construct(PortfolioCategory $portfolio_categories)
    {
        $this->portfolio_categories = $portfolio_categories;
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
        $data['title']    = 'Portfolio Categories Management ';
        return view('admin.portfolio-categories.index',$data);
    }

    protected function getView($forAjax = null){
      
        $data['categories'] =  $this->portfolio_categories->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.portfolio-categories.listing' : 'admin.portfolio-categories.index';
        return view($view, $data);
    }
    public function handleAjax($request)
    {
        $query = $this->portfolio_categories;
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('name', 'like', "$search%");
        }
        $data['categories'] =  $query->paginate($this->perpage);
        $data['appendHtml'] = view('admin.portfolio-categories.listing', $data)->render();
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
            'name' =>'required|unique:portfolio_categories'
        ]);
        $id = $request->category_id ?? null;
        $dbData = $request->all();
        $dbData['user_id'] = auth()->user()->id;
        $message = !empty($id) ? 'Successfully updated portfolio category.' : 'Successfully created portfolio category.';
        $this->portfolio_categories->updateOrCreate(['id' => $id, 'user_id' =>auth()->user()->id ],$dbData);
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
        return $this->portfolio_categories
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
            $portfolio_category = $this->portfolio_categories->find($id);
            if (!isset($portfolio_category)) {
                return response()->json(['message' => 'No portfolio category Found.'], 404);
            }
            $isDeleted = $portfolio_category->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted category.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
