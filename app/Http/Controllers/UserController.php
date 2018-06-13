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

      $user->name = $user->name;
      $user->email = $request->email;
      $user->city = $request->city;
      $user->street = $request->street . " " . $request->number;
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
      if (CraneReservation::where('time', $request->time)->where('date', $request->date)->first() !== null) {
        throw new \Exception("Error Bestaat al", 1);
      }
      CraneReservation::create([
        'user_id' => Auth::user()->id,
        'boat_id' => $request->boat_id,
        'date' => $request->date,
        'time' => $request->time,
        'type' => $request->type
      ]);

      return redirect()
        ->back()
        ->with('status', 'De reservering is geplaatst om ' . \Carbon\Carbon::parse($request->time)->format('d/m/Y H:i:s'));
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

    public function postGetReservationData($date)
    {
      $times = [];
      $start_time = Carbon::parse('0000-00-00 08:30')->format('H:i');
      $end_time = Carbon::parse('0000-00-00 16:00')->format('H:i');
      $interval = Settings::first()->kraan_tijd_vereist;
      $reservations = CraneReservation::where('date', Carbon::parse($date)->format('Y-m-d'))->get();
      $current_time = Carbon::parse($start_time);


      while ($current_time->format('H:i') != $end_time) {
        if (null !== $reservations->first()) {
          foreach ($reservations as $reservation) {
            if (Carbon::parse($reservation->time)->format('H:i') != Carbon::parse($current_time)->format('H:i')) {
              $times[] = $current_time->format('H:i');
            }
          }
        } else {
          $times[] = $current_time->format('H:i');
        }
        $current_time = $current_time->addMinutes($interval);
      }

      return json_encode($times);
    }
}
