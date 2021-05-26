<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\DefaultCreateTrait;
use App\Http\Traits\PortfolioImagesTrait;
use App\Http\Traits\PortfolioSettingsTrait;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Setting;
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
        $user_id = auth()->user()->id;
        $data['title']    = 'Portfolio Management ';
        $data['portfolio_categories'] =  $this->getPortfolioCategories();
        $data['portfolios'] =  $this->portfolio->where('user_id', $user_id)->with('category')->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.portfolios.listing' : 'admin.portfolios.index';
        return view($view, $data);
    }
    public function getPortfolioCategories(){
        $user_id = auth()->user()->id;
        return PortfolioCategory::orderBy('name')->where('user_id', $user_id)->get();
    }
    public function handleAjax($request)
    {
        $is_superadmin =  auth()->user()->role_id == 1;
        $user_id = auth()->user()->id;
        $query = $this->portfolio->with('user', 'category');
        if(!$is_superadmin){
            $query = $query->where('user_id', $user_id);
        }
        if ($request->Has('cat_filter') && !empty($request->cat_filter)) {
            $query = $query->where('pcat_id',  intval($request->cat_filter));
        }
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('name', 'like', "$search%");
        }
        $data1['portfolios'] =  $query->paginate($this->perpage);
        $response['appendHtml'] = view('admin.portfolios.listing', $data1)->render();
        $response['count'] = $query->paginate($this->perpage)->count();
        return $response;
    }
    public function getDataCount(){
        $user_id = auth()->user()->id;
        return $this->portfolio->where('user_id', $user_id)->count();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['portfolio_categories'] =  $this->getPortfolioCategories();
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
        $data = $request->except('_token');
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
        $response['count'] = $this->getDataCount();
        if($this->getDataCount() > 0){
            $this->createActivity(auth()->user(), 'portfolio', 'store', $data);
            $this->createPortfolioSectionSettings(auth()->user());
        }
        return response()->json($response, 200);
    }

    public function createPortfolioSectionSettings($user)
    {
        $contact_form_setting = Setting::where('user_id', $user->id)
            ->where('setting', 'hide_portfolio')
            ->where('page', 'portfolio')
            ->first() ?? null;

        if (!$contact_form_setting) {
            Setting::create([
                'value' => '0',
                'setting' => 'hide_portfolio',
                'user_id' => $user->id,
                'page' => 'portfolio',
                'is_apply' => '1'
            ]);
        }
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
        $this->createActivity(auth()->user(), 'portfolio', 'update', $request->all());
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
                $data['count'] = $this->getDataCount();
                $this->createActivity(auth()->user(), 'portfolio', 'destroy');
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Bulk Actions On Resources
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request, $action)
    {
        $payload = $request->payload;
        if($action == 'delete'){
            $portfolio = $this->portfolio->whereIn('id', $payload);
            if (isset($portfolio)) {
                $portfolio->delete();
            }
        }
        $this->createActivity(auth()->user(), 'portfolio_bulk', 'delete');
        $data['count'] = $this->getDataCount();
        $data['appendHtml'] =  $this->getView('ajax')->render();
        return $this->successResponse($data, 'Deleted Successfully. ');
    }
}
