<?php

namespace App\Exports;

use App\Models\CrcM;
use App\Models\EupM;
use App\Models\KendaraanM;
use App\Models\KontrakM;
use App\Models\ResinM;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class UserExportExcel implements FromView, ShouldAutoSize
{
    use Exportable;

    private $data;

    public function __construct()
    {
        $this->data = User::all();
    }

    public function view() : View
    {
        return view('pages.hc.kelolauser.export', [
            'data' => $this->data
        ]);
    }
}
