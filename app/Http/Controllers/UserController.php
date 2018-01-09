<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Invoice;
use App\CraneReservation;
use App\Settings;
use App\Boats;
use App\RentedBox;

use Carbon\Carbon;

use Auth;
use PDF;

class UserController extends Controller
{
    public function getProfile()
    {
      return view('user.profile')
        ->with('user', Auth::user());
    }

    public function postProfile(Request $request)
    {
      $user = Auth::user();

      $user->name = $request->name;
      $user->email = $request->email;
      $user->city = $request->city;
      $user->street = $request->street;
      $user->zip = $request->zip;
      $user->tel = $request->tel;

      $user->save();

      return redirect()
        ->back()
        ->with('status', 'Uw wijzigingen zijn succesvol opgeslagen!');
    }

    public function getDashboard()
    {
      $crane_reservations = CraneReservation::all();
      $start_date = (new Carbon(date('Y-m-d') . Settings::first()->crane_start_time));
      $current_time = $start_date->addMinutes(30);

      return view('user.dashboard')
        ->with('rented_boxes', Auth::user()->rentedBox)
        ->with('crane_reservations', $crane_reservations)
        ->with('start_date', $start_date)
        ->with('current_time', $start_date);
    }

    public function getInvoicePdf($id)
    {
      $invoice = Invoice::findOrFail($id);

      $renderedInvoice = view('layouts.invoice_template')
        ->with('invoice', $invoice)
        ->render();

      $pdf = PDF::loadHtml($renderedInvoice);
      $pdf->setPaper('a4', 'landscape');
      return $pdf->stream();
    }

    public function postPlan(Request $request)
    {
      $start_date = (new Carbon(date('Y-m-d') . Settings::first()->crane_start_time));
      $current_time = $start_date->addMinutes(30);

      if ($request->date >= \Carbon\Carbon::now()) {
        return redirect()
          ->back()
          ->withInput()
          ->withErrors('De datum moet minimaal vandaag zijn!');
      }

      $reservations = CraneReservation::where('date', \Carbon\Carbon::parse($request->date))->orderByDesc('time')->get();

      if (null == $reservations->first()) {
        CraneReservation::create([
          'user_id' => Auth::user()->id,
          'boat_id' => $request->boat_id,
          'date' => $request->date,
          'time' => $current_time,
          'type' => $request->type
        ]);

        return redirect()
          ->back()
          ->with('status', 'De reservering is geplaatst om ' . $current_time->format('d/m/Y H:i:s'));
      }
      CraneReservation::create([
        'user_id' => Auth::user()->id,
        'boat_id' => $request->boat_id,
        'date' => $request->date,
        'time' => $time = \Carbon\Carbon::parse($reservations->max('time'))->addMinutes(30),
        'type' => $request->type
      ]);

      return redirect()
        ->back()
        ->with('status', 'De reservering is geplaatst om ' . $time->format('d/m/Y H:i:s'));
    }

    public function postInHabour(Request $request)
    {
      $boat = Boats::find($request->boat_id);

      if ($request->inHabour == 'on') {
        $boat->inHabour = true;
      } else {
        $boat->inHabour = false;
      }

      $boat->save();

      return redirect()->back()->with('status', 'De wijzigingen zijn successvol opgeslagen');
    }
}
