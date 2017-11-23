<?php

namespace App;

use Excel;
use Auth;

class ExportInvoices
{
  public static function excel()
  {
    return Excel::create('Factuur overzicht', function ($excel) {
      $excel->setTitle('Facuur overzicht');

      $excel
        ->setCreator(Auth::user()->name)
        ->setCompany(config('app.name'));

      self::callSheet($excel, date('Y'));
    })->download('xlsx');
  }

  private static function callSheet($excel, $name)
  {
    $excel->sheet($name, function($sheet) {
      $sheet->fromModel(self::parseData(), null, 'A1', false, false);

      $sheet->cells('A1:G1', function($cells) {
        $cells->setFontWeight('bold');
      });
    });
  }

  private static function parseData()
  {
    $subtotal = 0;

    $data = [
      'keys' => [
        'Naam',
        'Ontvanger',
        'Betalen voor',
        'Betaald op',
        'Subtotaal',
        'Btw',
        'Totaal'
      ],
    ];


    foreach (Invoice::all() as $invoice) {
      foreach($invoice->attributes()->get() as $line) {
        $subtotal += $line->quantity * $line->price;
      }
      $data[] = [
          $invoice->name,
          User::find($invoice->user_id)->name,
          $invoice->dueDate->format('d/m/Y'),
          (isset($invoice->payed_at)) ? $invoice->payed_at : 'nog niet betaald',
          '€ ' . $invoice->getSubTotal(),
          '€ ' . $invoice->getBtw(),
          '€ ' . $invoice->getTotal(),
        ];
    }

    $data[] = [
      '',
      '',
      '',
      '',
      '',
      '',
      '________',
      '+',
    ];
    $data[] = [
      '',
      '',
      '',
      '',
      '',
      'Totaal gefactureerd',
      '€ ' . Invoice::totalOfAll(),
    ];

    return $data;
  }
}
