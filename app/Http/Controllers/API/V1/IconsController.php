<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IconsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $iconType = $request->query('iconset');
        $icons = config($iconType); sort($icons);
        return response()->json(compact('icons'), 200);
    }

}
