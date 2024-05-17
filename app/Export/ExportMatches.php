<?php

namespace App\Export;

use \App\Lib\Queries\QueryBase;

use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Exports\Concerns\WithCustomProperties;
use Maatwebsite\Excel\Writer;

class ExportMatches implements FromView, ShouldAutoSize
{
  public $view;
  public $data;

    public function __construct($view, $data){

      $this->view = $view;
      $this->data = $data;
  }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
       return view('admin.prediction.export.matches',['data' => $this->data]);
    }

    public function registerEvents(): array{
      return [
          AfterSheet::class    => function(AfterSheet $event) {
              $event->sheet->styleCells(
                'A1',
                [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]
            );
          },
      ];
    }
}
