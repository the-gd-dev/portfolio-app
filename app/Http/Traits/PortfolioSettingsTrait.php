<?php

namespace App\Http\Traits;

use App\Models\Setting;
use Illuminate\Http\Request;

trait PortfolioSettingsTrait
{

    /**
     * Updating Settings
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->except('hide_portfolio');
        Setting::updateOrCreate(['setting' => 'hide_portfolio', 'page' => 'portfolio', 'user_id' => $user_id], [
            'value' => isset($request->hide_portfolio) ? '1' : '0',
            'setting' => 'hide_portfolio',
            'user_id' => $user_id,
            'page' => 'portfolio',
            'is_apply' => '1'
        ]);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['setting' => $key, 'page' => 'portfolio',  'user_id' => $user_id], [
                'value' => $value['value'],
                'user_id' => $user_id,
                'page' => 'portfolio',
                'setting' => $key,
                'is_apply' => isset($value['apply']) ? '1' : '0'
            ]);
        }
        $message = 'Successfully updated portfolio settings.';
        $response = $this->successResponse([], $message);
        return response()->json($response, 200);
    }
    /**
     * Fetch Settings
     * @return \Illuminate\Http\Response
     */
    public function getPortfolioSettings()
    {
        $user_id = auth()->user()->id;
        $responseData  = [];
        $responseData = $this->getSettings($user_id, 'portfolio', 'true');
        return response()->json(['data' => $responseData], 200);
    }
}
