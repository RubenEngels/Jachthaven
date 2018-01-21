<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Settings;
use App\Events;
use App\Documents;
use App\InvoiceProducts;
use App\Boats;
use App\User;
use App\Box;
use App\Pier;

class AdminController extends Controller
{
    public function getSettings()
    {
      $settings = Settings::first();
      $invoice_products = InvoiceProducts::paginate(5);

      return view('admin.settings')
        ->with('settings', $settings)
        ->with('invoice_products', $invoice_products);
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
      $settings->crane_start_time = (isset($request->crane_start_time)) ? $request->crane_start_time : $settings->crane_start_time;
      $settings->period = (isset($request->period)) ? $request->period : $settings->period;

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

      $request->validate([
        'date' => 'required|after_or_equal:today',
        'from' => ["regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/"],
        'till' => ["regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/"],
      ]);

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

    public function postChangeDefaultInvoiceProduct($id, Request $request)
    {
      $product = InvoiceProducts::findOrFail($id);

      $product->name = $request->name;
      $product->quantity = $request->quantity;
      $product->price = $request->price;
      $product->default_on_invoice = ($request->default_on_invoice == 'on') ? 1 : 0;

      $product->save();

      return redirect()
        ->back()
        ->with('status', 'Het product is succesvol gewijzigd!');
    }

    public function postNewInvoiceProduct(Request $request)
    {
      InvoiceProducts::create([
        'name' => $request->name,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'default_on_invoice' => ($request->default_on_invoice == 'on') ? 1 : 0,
      ]);

      return redirect()
        ->back()
        ->with('status', 'Het product is succesvol aangemaakt!');
    }

    public function getDeleteDefaultInvoiceProduct($id)
    {
      $product = InvoiceProducts::findOrFail($id);

      $product->delete();

      return redirect()
        ->back()
        ->with('status', 'Het product is succesvol verwijderd!');
    }

    public function getCreateBoat()
    {
      $boats = Boats::paginate(10);

      return view('admin.boat')
        ->with('boats', $boats);
    }

    public function postCreateBoat(Request $request)
    {
      Boats::create([
        'name' => $request->name,
        'user_id' => $request->owner,
        'brand' => $request->brand,
        'type' => $request->type,
        'color' => $request->color,
        "length" => $request->length,
        "width" => $request->width,
        "depth" => $request->depth,
        "heigth" => $request->heigth,
        "boatType" => $request->boatType,
      ]);

      $user = User::find($request->owner);

      $user->owner = true;
      $user->save();

      return redirect()->back()->with('status', 'De boot is succesvol toegevoegd');
    }

    public function postEditBoat($id, Request $request)
    {
      $boat = Boats::find($id);

      $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      $imageName = time() . '.' . $request->image->getClientOriginalExtension();
      $request->image->move(public_path('uploads/boats'), $imageName);

      $boat->image_url = $imageName;
      $boat->save();

      return redirect()->back()->with('status', 'De boot is succesvol aangepast');
    }

    public function getDeleteBoat($id)
    {
      Boats::destroy($id);

      return redirect()->back()->with('status', 'De boot is succesvol verwijderd');
    }

    public function getUsers()
    {
      $users = User::all();

      return view('admin.users')
        ->with('users', $users);
    }

    public function postEditUsers(Request $request)
    {
      $user = User::find($request->id);
      $admins = User::where('admin', true)->count();

      if ($request->check == 'show') {
        if ($request->isAdmin == 'on') {
          $user->admin = true;
        } else {
          if ($admins <= 1) {
            return redirect()->back()->with('status', 'Er is nog maar 1 administrator over. Je kan dit niet doen!');
          }
          $user->admin = false;
        }
      }

      if ($request->isOwner == 'on') {
        $user->owner = true;
      } else {
        $user->owner = false;
      }

      if ($request->isManagement == 'on') {
        $user->management = true;
      } else {
        $user->management = false;
      }

      if ($request->isDocumenter == 'on') {
        $user->documenter = true;
      } else {
        $user->documenter = false;
      }

      $user->save();

      return redirect()->back()->with('status', 'De gebruiker is succesvol aangepast');
    }

    public function getDeleteUser($id)
    {
      User::destroy($id);

      return redirect()->back()->with('status', 'De gebruiker is succesvol verwijderd');
    }

    public function postEditLayout(Request $request)
    {
      if ($request->walplaatsen + $request->boxes !== 400) {
        return redirect()->back()->with('status', 'Het totaal moet 400 zijn!');
      }

      Box::truncate();
      Pier::truncate();

      $pier_id = 0;

      for ($i=0; $i < $request->walplaatsen; $i++) {
        Box::create([
          'public_id' => $i + 1,
          'isWalplaats' => true,
        ]);
      }

      for ($i=0; $i < $request->boxes; $i++) {
        if ($i % 10 == 0 OR $i == 0) {
          $pier = Pier::create([
            'public_id' => $pier_id + 1,
          ]);
          $pier_id = $pier->id;
        }
        Box::create([
          'public_id' => $i + 1,
          'isWalplaats' => false,
          'pier_id' => $pier_id
        ]);
      }

      return redirect()->back()->with('status', 'De box / wal plaatsen zijn opnieuw ingedeeld!');
    }

    public function postChangeUser(Request $request)
    {
      $user = User::find($request->id);

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
}
