<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\PortfolioImagesTrait;
use App\Http\Traits\PortfolioSettingsTrait;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;

class PortfoliosController extends Controller
{
    use PortfolioImagesTrait, PortfolioSettingsTrait;
    protected $portfolio;
    protected $perpage = 10;
    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
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
        $data['portfolio_categories'] =  PortfolioCategory::orderBy('name')->get();
        $data['title']    = 'Portfolio Management ';
        return view('admin.portfolios.index', $data);
    }

    protected function getView($forAjax = null)
    {
        $data['title']    = 'Portfolio Management ';
        $data['portfolio_categories'] =  PortfolioCategory::orderBy('name')->get();
        $data['portfolios'] =  $this->portfolio->with('category')->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.portfolios.listing' : 'admin.portfolios.index';
        return view($view, $data);
    }
    public function handleAjax($request)
    {
        $query = $this->portfolio;
        if ($request->Has('cat_filter') && !empty($request->cat_filter)) {
            $query = $query->where('pcat_id',  intval($request->cat_filter));
        }
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('name', 'like', "$search%");
        }
        $data1['portfolios'] =  $query->paginate($this->perpage);
        $data['appendHtml'] = view('admin.portfolios.listing', $data1)->render();
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['portfolio_categories'] =  PortfolioCategory::orderBy('name')->get();
        $data['title']    = 'Create Portfolio';
        return view('admin.portfolios.update-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->all();
        $data['user_id'] =  $user_id;
        $id = $request->portfolio_id ?? null;
        $this->validate($request, [
            'name' => 'required',
        ]);
        $message = !empty($id) ? 'Successfully updated portfolio.' : 'Successfully created portfolio.';
        $portfolio = $this->portfolio->updateOrCreate(['user_id' => $user_id, 'id' => $id], $data);
        if (
            isset($portfolio) &&
            $request->has('portfolio_images') &&
            !empty($request->portfolio_images)
        ) {
            $this->portfolioImagesStore(json_decode($request->portfolio_images), $portfolio->id);
        }
        $returnUrl = !empty($id) ? route('admin.portfolios.edit', $id) : route('admin.portfolios.index') ;
        $response = $this->successResponse(['url' => $returnUrl ], $message);
        return response()->json($response, 200);
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $portfolio = $this->portfolio->find($id);
        if (!isset($portfolio)) {
            return response()->json(['message' => 'No portfolio Found.'], 404);
        }
        if($request->has('sorted_data')){
            return $this->portfolioImagesSorting($request->sorted_data,$id );
        }
        $portfolio->update($request->all());
        $response = $this->successResponse([], '!! Updated !!');
        return response()->json($response, 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = $this->portfolio->with('images', 'category')->find($id);
        if (!isset($portfolio)) {
            abort(404);
        }
        $data['portfolio_categories'] =  PortfolioCategory::orderBy('name')->get();
        $data['title']      = 'Edit Portfolio';
        $data['portfolio']  =  $portfolio;
        return view('admin.portfolios.update-create', $data);
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
            $portfolio = $this->portfolio->find($id);
            if (!isset($portfolio)) {
                return response()->json(['message' => 'No portfolio Found.'], 404);
            }
            $this->deleteOldFiles($portfolio->id);
            $isDeleted = $portfolio->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted portfolio.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
