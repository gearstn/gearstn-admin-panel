<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public static $settings = [
        'about_us_en' => 'About Us English',
        'about_us_ar' => 'About Us Arabic',
        'mission_en' => 'Mission English',
        'mission_ar' => 'Mission Arabic',
        'vision_en' => 'Vision English',
        'vision_ar' => 'Vision Arabic',
        'services_general_en' => 'General Services English',
        'services_general_ar' => 'General Services Arabic',
        'services_distributor_en' => 'Distributor Services English',
        'services_distributor_ar' => 'Distributor Services Arabic',
        'services_acquires_en' => 'Acquires Services English',
        'services_acquires_ar' => 'Acquires Services Arabic',
        'terms_and_conditions_en' => 'Terms and Conditions English',
        'terms_and_conditions_ar' => 'Terms and Conditions Arabic',
        'privacy_policy_en' => 'Privacy Policy English',
        'privacy_policy_ar' => 'Privacy Policy Arabic',
        'faq_en' => 'FAQ English',
        'faq_ar' => 'FAQ Arabic',
    ];

   /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $settings = collect();
        foreach ($this::$settings as $s => $x) {
            $setting = Setting::firstOrCreate(['type' => $s], ['value' => '']);
            $setting['message'] = $x;
            $settings->add($setting);
        }
        return view('admin.components.setting.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {

        $inputs = $request->except("_token");
        foreach ($inputs as $input => $value) {
            if (array_key_exists($input, $this::$settings)) {
                Setting::where("type", $input)->update(['value' => $value]);
            } else {
                return redirect()->route("settings.index")->withErrors("Invalid values");
            }
        }
        return redirect()->route('settings.index')->with(['success' => 'Settings ' . __("messages.update")]);
    }
}
