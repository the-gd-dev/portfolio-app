<?php
namespace App\Http\Traits;
use App\Models\Setting;

trait CommonTrait
{
    /**
     * Fetch Settings
     * @return \Illuminate\Http\Response
     */
    public function getSettings($user_id, $page, $ajax = null)
    {
        $responseData  = [];
        $dbData = Setting::where('user_id', $user_id)->where('page', $page)->get();
        if ($dbData->count() > 0) {
            foreach ($dbData as $key => $value) {
                $responseData[$value->setting] = (object)['value' => $value->value, 'apply' => $value->is_apply];
            }
        }
        return (object)$responseData;
    }
}