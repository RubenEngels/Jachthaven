<?php

namespace App;

use Excel;
use Auth;

class ExportCrane
{
  public static function excel()
  {
    return Excel::create('Kraan overzicht', function ($excel) {
      $excel->setTitle('Kraan overzicht');

      $excel
        ->setCreator(Auth::user()->name)
        ->setCompany(config('app.name'));

      self::callSheet($excel, date('Y'));
    })->download('xlsx');
  }

  public static function callSheet(\Maatwebsite\Excel\Writers\LaravelExcelWriter $excel, $name)
  {
    $excel->sheet($name, function($sheet) {
      $sheet->fromModel(self::parseData(), null, 'A1', false, false);

      $sheet->cells('A1:D1', function($cells) {
        $cells->setFontWeight('bold');
      });
    });
  }

  private static function parseData()
  {
    $data = [
      'keys' => [
        'Eigenaar',
        'Boot',
        'Actie',
        'Tijd',
      ],
    ];

    foreach (CraneReservation::where('date', \Carbon\Carbon::now()->format('y-m-d'))->get() as $reservation) {
      $data[] = [
        $reservation->user->name,
        $reservation->boat->name,
        ($reservation->type == 'in-water') ? 'Boot in het water zetten' : 'Boot op de kant zetten' ,
        $reservation->time,
      ];
    }

    return $data;
  }
}
