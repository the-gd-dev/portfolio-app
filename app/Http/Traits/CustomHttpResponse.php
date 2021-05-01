<?php
namespace App\Http\Traits;
use Illuminate\Support\Arr;
trait CustomHttpResponse
{
    function formErrorResponse($errors = [],$message = null){
        $response['status'] = false;
        $response['response_code'] = 409;
        $response['message'] = !isset($message) ? 'Error...!!!' : $message ;;
        $response['errors'] = $errors; 
        $response['form_errors'] = true; 
        return $response;
    }

    function successResponse($data = [],$message = null){
        $response['status'] = true;
        $response['response_code'] = 200;
        $response['message'] = !isset($message) ? 'Success...!!!' : $message ;
        $response['data'] = $data; 
        return $response;
    }
    
    function errorResponseToaster($toaster = []){
        $response['show_toaster'] = true;
        $response['response_code'] = 500;
        $response['status']  = (isset($toaster['status'])) ?  $toaster['status'] : false ;
        $response['heading'] = (isset($toaster['heading'])) ?  $toaster['heading'] : false ;
        $response['icon']    = (isset($toaster['icon'])) ?  $toaster['icon'] : false ;
        $response['delay']   = (isset($toaster['delay'])) ?  $toaster['delay'] : false ;
        $response['position'] = (isset($toaster['position'])) ?  $toaster['position'] : false ;
        $response['loaderBg'] = (isset($toaster['loaderBg'])) ?  $toaster['status'] : false ;
        return $response;
    } 

    function successResponseHtml($data = [],$message = null){
        $response['status'] = true;
        $response['response_code'] = 200;
        $response['message'] = !isset($message) ? 'Success...!!!' : $message ;
        $response['html'] = (isset($data['html'])) ?  $data['html'] : false ;
        $response['data'] = Arr::except($data,['html']); 
        return $response;
    } 
}
