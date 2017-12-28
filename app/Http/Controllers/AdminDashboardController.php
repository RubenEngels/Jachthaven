<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserNotifications;
use App\MailingList;
use App\Newsletters;
use App\Mail\Newsletter;
use App\Invoice;
use App\InvoiceAttributes;
use App\User;
use App\CreditedInvoices;
use App\Mail\SendInvoice;
use App\InvoiceProducts;
use App\ExportInvoices;
use App\ExportCrane;
use App\CraneReservation;
use App\Settings;
use Carbon\Carbon;
use Auth;
use PDF;

class AdminDashboardController extends Controller
{
  public function getDashboard()
  {
    $active = UserNotifications::where('show', true)->paginate(2, ['*'], 'notifications');
    $mailing_list = MailingList::paginate(5, ['*'], 'mailing');
    $newsletters = Newsletters::paginate(5, ['*'], 'newsletter');
    $users = User::paginate(5, ['*'], 'users');
    $defaultInvoiceItems = InvoiceProducts::all();
    $crane_reservations = CraneReservation::where('date', Carbon::now()->format('y-m-d'))->get();


    return view('admin.dashboard.index')
    ->with('active', $active)
    ->with('mailing_list', $mailing_list)
    ->with('newsletters', $newsletters)
    ->with('users', $users)
    ->with('defaultInvoiceItems', $defaultInvoiceItems)
    ->with('crane_reservations', $crane_reservations);
  }

  public function postNotifications(Request $request)
  {
    if (isset($request->id)) {
      $notification = UserNotifications::findOrFail($request->id);
      $save = 'Uw wijzigingen zijn succesvol opgeslagen!';
    } else {
      $notification = new UserNotifications;
      $save = 'De melding is succesvol aangemaakt!';
    }

    $notification->message = $request->message;

    $notification->save();

    return redirect()
      ->back()
      ->with('status', $save);
  }

  public function getDeleteNotifications($id)
  {
    $notification = UserNotifications::findOrFail($id);

    $notification->show = false;
    $notification->save();

    return redirect()
      ->back()
      ->with('status', 'De melding is succesvol verwijderd!');
  }

  public function getMailDelete($id)
  {
    $recipient = MailingList::findOrFail($id);

    $recipient->delete();

    return redirect()
      ->back()
      ->with('status', 'De onvanger is succesvol verwijderd!');
  }

  public function postNewsletter(Request $request)
  {
    if (isset($request->id)) {
      $newsletter = Newsletters::findOrFail($request->id);
      $message = 'Uw wijzingen zijn succesvol opgeslagen!';
    } else {
      $newsletter = new Newsletters;
      $message = 'Uw nieuwsbrief is succesvol aangemaakt!';
    }

    $newsletter->name = $request->name;
    $newsletter->content = $request->content;

    $newsletter->save();

    return redirect()
      ->back()
      ->with('status', $message);
  }

  public function getDeleteNewsletter($id)
  {
    $recipient = Newsletters::findOrFail($id);

    $recipient->delete();

    return redirect()
      ->back()
      ->with('status', 'De nieuwsbrief is succesvol verwijderd!');
  }

  public function sendMail(Request $request)
  {

    if ($request->to == 'everyone') {
      $mailing_list = MailingList::all();

      foreach ($mailing_list as $user) {
        \Mail::to($user->email)->send(new Newsletter($request->newsletter));
      }
    } else {
      \Mail::to($request->to)->send(new Newsletter($request->newsletter));
    }

    return redirect()
      ->back()
      ->with('status', 'De nieuwsbrief is succesvol verstuurd!');
  }

  public function postCreditInvoice(Request $request, $id)
  {
    CreditedInvoices::create([
      'invoice_id' => $id,
      'reason' => $request->reason,
      'amount' => $request->amount,
    ]);

    return redirect()
      ->back()
      ->with('status', 'De factuur is succesvol gekrediteerd!');
  }

  public function getDeleteInvoice($id)
  {
    $invoice = Invoice::findOrFail($id);

    $invoice->delete();

    return redirect()
      ->back()
      ->with('status', 'De factuur is succesvol verwijderd!');
  }

  public function postNewInvoice(Request $request)
  {
    $final = [];
    $i = 0;
    foreach ($request->item_name as $name) {
      $final[$i]['name'] = $name;
      $i++;
    }
    $i = 0;
    foreach ($request->item_price as $price) {
      $final[$i]['price'] = $price;
      $i++;
    }
    $i = 0;
    foreach ($request->item_quantity as $quantity) {
      $final[$i]['quantity'] = $quantity;
      $i++;
    }
    collect($final);

    $id = \DB::table('invoices')->insertGetId([
      'name' => $request->name,
      'user_id' => $request->for,
      'sendDate' => \Carbon\Carbon::now(),
      'dueDate' => \Carbon\Carbon::parse($request->dueDate),
    ]);

    foreach ($final as $line) {
      if ($line['name'] != '') {
        InvoiceAttributes::create([
          'invoice_id' => $id,
          'name' => $line['name'],
          'price' => $line['price'],
          'quantity' => $line['quantity'],
        ]);
      }
    }

    $invoice = Invoice::findOrFail($id);

    $renderedInvoice = view('layouts.invoice_template')
      ->with('invoice', $invoice)
      ->render();

    $pdf = PDF::loadHtml($renderedInvoice);
    $pdf->setPaper('a4', 'landscape');

    $pdf->save(public_path() . '/invoices/' . str_slug($invoice->name) . '-' . $invoice->id .'.pdf');

    \Mail::to($invoice->user->email)->send(new SendInvoice(public_path() . '/invoices/' . str_slug($invoice->name) . '-' . $invoice->id .'.pdf', $invoice->user_id, $invoice->id));

    return redirect()
      ->back()
      ->with('status', 'De factuur is succesvol aangemaakt!');
  }

  public function postGetDefaultInvoiceProduct(Request $request)
  {
    $product = InvoiceProducts::findOrFail($request->id);

    return [
      'name' => $product->name,
      'quantity' => $product->quantity,
      'price' => $product->price,
    ];
  }

  public function exportInvoices()
  {
    return ExportInvoices::excel();
  }

  public function getSetAsPayed($id, $date)
  {
    $invoice = Invoice::find($id);

    $invoice->payed_at = \Carbon\Carbon::parse($date);

    $invoice->save();

    return redirect()
      ->back()
      ->with('status', 'De factuur is succesvol op betaald gezet!');
  }

  public function getExportCrane()
  {
    return ExportCrane::excel();
  }
}
