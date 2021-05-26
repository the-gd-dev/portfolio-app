<?php

namespace App\Http\Controllers;

use App\Http\Traits\ActivityTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Traits\CustomHttpResponse;
use App\Http\Traits\CommonTrait;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CustomHttpResponse, CommonTrait, ActivityTrait;
}
