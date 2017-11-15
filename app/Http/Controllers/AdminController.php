<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Settings;
use App\Events;
use App\Documents;

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
        ->with('status', 'Uw wijzigingen zijn succesvol ogeslagen!');
    }

    public function getEvents()
    {
      $events = Events::orderBy('date', 'asc')->paginate(4);

      return view('admin.events')
        ->with('events', $events);
    }

    public function postEvents(Request $request)
    {
      if (isset($request->id)) {
        $event = Events::find($request->id);
        $message = 'Uw wijzigingen zijn succesvol ogeslagen!';
      } else {
        $event = new Events;
        $message = 'Uw evenement is succesvol aangemaakt!';
      }

      $event->name = $request->name;
      $event->location = $request->location;
      $event->date = $request->date;
      $event->from = $request->from;
      $event->till = $request->till;

      $event->save();

      return redirect()
        ->back()
        ->with('status', $message);
    }

    public function getDeleteEvents($id)
    {
      $event = Events::findOrFail($id);

      $event->delete();

      return redirect()
        ->back()
        ->with('status', 'Het evenement is succesvol verwijderd!');
    }

    public function getDocuments()
    {
      $documents = Documents::orderBy('id', 'desc')->paginate(5);

      return view('admin.documents')
        ->with('documents', $documents);
    }

    public function postEditDocument(Request $request)
    {
      $document = Documents::find($request->id);

      // dd($document->name);

      $document->name = $request->name;
      $document->public = ($request->public == 'false') ? false : true;

      $document->save();

      return redirect()
        ->back()
        ->with('status', 'Uw wijzigingen zijn succesvol ogeslagen!');
    }

    public function postNewDocument(Request $request)
    {
      $request->validate([
        'file' => 'required|max:4096',
      ]);

      $fileName = time().'.'. $request->file->getClientOriginalExtension();
      $request->file->move(public_path('/uploads/documents/'), $fileName);

      Documents::create([
        'name' => $request->file->getClientOriginalName(),
        'link' => '/uploads/documents/' . $fileName,
        'public' => ($request->public == 'true') ? true : false,
      ]);

      return redirect()
        ->back()
        ->with('status', 'Uw document is successvol gepubliceerd!');
    }

    public function getDeleteDocument($id)
    {
      $document = Documents::findOrFail($id);

      $document->delete();

      return redirect()
        ->back()
        ->with('status', 'Het document is succesvol verwijderd!');
    }

    public function getDownloadDocument($id)
    {
      $document = Documents::findOrFail($id);

      return response()->download(public_path($document->link));
    }
}
