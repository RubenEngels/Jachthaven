<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Settings;

class AdminController extends Controller
{
    public function getDashboard()
    {
      return view('admin.dashboard');
    }

    public function getSettings()
    {
      return view('admin.settings')
        ->with('settings', Settings::first());
    }

    public function postSettings(Request $request)
    {
      try {
        $settings = Settings::firstOrFail();
      } catch (\Exception $e) {
        $settings = new Settings;
      }

      $settings->box_jaar_huur = (isset($request->box_jaar_huur)) ? $request->box_jaar_huur : $settings->box_jaar_huur;
      $settings->toeristen_belasting = (isset($request->toeristen_belasting)) ? $request->toeristen_belasting : $settings->toeristen_belasting;
      $settings->btw = (isset($request->btw)) ? $request->btw : $settings->btw;
      $settings->inschrijf_geld = (isset($request->inschrijf_geld)) ? $request->inschrijf_geld : $settings->inschrijf_geld;
      $settings->lidmaatschap_prijs = (isset($request->lidmaatschap_prijs)) ? $request->lidmaatschap_prijs : $settings->lidmaatschap_prijs;
      $settings->kraan_tijd_vereist = (isset($request->kraan_tijd_vereist)) ? $request->kraan_tijd_vereist : $settings->kraan_tijd_vereist;

      $settings->save();

      return redirect()
        ->back()
        ->with('status', 'Uw wijzigingen zijn succesvol opgeslagen!');
    }
}
