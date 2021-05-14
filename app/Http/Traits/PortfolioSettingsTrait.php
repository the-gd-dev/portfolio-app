<?php

namespace App\Http\Traits;

use App\Models\PortfolioSettings;
use Illuminate\Http\Request;

trait PortfolioSettingsTrait
{
    public function updateSettings(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->except('hide_portfolio');
        PortfolioSettings::updateOrCreate(['setting' => 'hide_portfolio', 'user_id' => $user_id], [
            'value' => isset($request->hide_portfolio) ? '1' : '0',
            'setting' => 'hide_portfolio',
            'user_id' => $user_id,
            'is_apply' => '1'
        ]);
        foreach ($data as $key => $value) {
            PortfolioSettings::updateOrCreate(['setting' => $key, 'user_id' => $user_id], [
                'value' => $value['value'],
                'user_id' => $user_id,
                'setting' => $key,
                'is_apply' => isset($value['apply']) ? '1' : '0'
            ]);           
        }
        $message = 'Successfully updated portfolio settings.';
        $response = $this->successResponse([], $message);
        return response()->json($response, 200);
    }
    public function getSettings()
    {
        $user_id = auth()->user()->id;
        $responseData  = [];
        $dbData = PortfolioSettings::where('user_id', $user_id)->get();
        if($dbData->count() > 0){
            foreach ( $dbData as $key => $value) {
                $responseData[$value->setting]['value'] = $value->value;
                $responseData[$value->setting]['apply'] = $value->is_apply;
            }
        }
        return response()->json(['data' => $responseData], 200);
    }
}
