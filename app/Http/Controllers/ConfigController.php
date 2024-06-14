<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\File;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('config.index');
    }

    /**
     * Show calendar.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function calendar()
    {
        return view('config.calendar');
    }

    public function data()
    {
        $model = [
            'name' => Config::where('key', 'company_name')->first()->value ?? null,
            'cif' => Config::where('key', 'company_cif')->first()->value ?? null,
            'address' => Config::where('key', 'company_address')->first()->value ?? null,
            'zip_code' => Config::where('key', 'company_zip_code')->first()->value ?? null,
            'town' => Config::where('key', 'company_town')->first()->value ?? null,
            'province' => Config::where('key', 'company_province')->first()->value ?? null,
            'phone' => Config::where('key', 'company_phone')->first()->value ?? null,
            'email' => Config::where('key', 'company_email')->first()->value ?? null,
            'company_app' => Config::where('key', 'company_app')->first()->value ?? null,
            'max_user_number' => Config::where('key', 'max_user_number')->first()->value ?? null,
            'theme_color' => Config::where('key', 'theme_color')->first()->value ?? null,
        ];

        return response()->json($model);
    }

    public function save(Request $request)
    {
        Config::updateOrCreate(
            ['key' => 'company_name'],
            [
                'value' => $request->name,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_cif'],
            [
                'value' => $request->cif,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_address'],
            [
                'value' => $request->address,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_zip_code'],
            [
                'value' => $request->zip_code,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_town'],
            [
                'value' => $request->town,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_province'],
            [
                'value' => $request->province,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_phone'],
            [
                'value' => $request->phone,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_email'],
            [
                'value' => $request->email,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'theme_color'],
            [
                'value' => $color = $this->rgbToHex($request->theme_color),
            ]
        );
        Config::updateOrCreate(
            ['key' => 'company_app'],
            [
                'value' => $request->company_app,
            ]
        );
        Config::updateOrCreate(
            ['key' => 'max_user_number'],
            [
                'value' => $request->max_user_number,
            ]
        );


        if ($request->logo && $request->logo != 'undefined') {
            $logo = File::create([
                'title' => pathinfo($request->logo->getClientOriginalName(), PATHINFO_FILENAME),
                'mime_type' => $request->logo->extension()
            ]);

            $filename = $logo->slug . '.' . $request->logo->extension();

            $request->logo->move(public_path('file') . '/' . time(), $filename);

            $logo->source = 'file' . '/' . time() . '/' . $filename;
            $logo->save();
            Config::updateOrCreate(
                ['key' => 'company_logo'],
                [
                    'value' => $logo->id,
                ]
            );
        }
        if ($request->minilogo && $request->minilogo != 'undefined') {
            $minilogo = File::create([
                'title' => pathinfo($request->minilogo->getClientOriginalName(), PATHINFO_FILENAME),
                'mime_type' => $request->minilogo->extension()
            ]);

            $filename = $minilogo->slug . '.' . $request->minilogo->extension();

            $request->minilogo->move(public_path('file') . '/' . time(), $filename);

            $minilogo->source = 'file' . '/' . time() . '/' . $filename;
            $minilogo->save();
            Config::updateOrCreate(
                ['key' => 'company_minilogo'],
                [
                    'value' => $minilogo->id,
                ]
            );
        }
        if ($request->favicon && $request->favicon != 'undefined') {
            $favicon = File::create([
                'title' => pathinfo($request->favicon->getClientOriginalName(), PATHINFO_FILENAME),
                'mime_type' => $request->favicon->extension()
            ]);

            $filename = $favicon->slug . '.' . $request->favicon->extension();

            $request->favicon->move(public_path('file') . '/' . time(), $filename);

            $favicon->source = 'file' . '/' . time() . '/' . $filename;
            $favicon->save();
            Config::updateOrCreate(
                ['key' => 'company_favicon'],
                [
                    'value' => $favicon->id,
                ]
            );
        }

        return response()->json(['success' => __('Configuración actualizada correctamente.')]);
    }

    protected function rgbToHex($rgb)
    {
        list($r, $g, $b) = sscanf($rgb, "rgb(%d, %d, %d)");
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}
