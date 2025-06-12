<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PrasaranaJalanExport;
use App\Imports\PrasaranaJalanImport;
use App\Models\PrasaranaJalan;

class PrasaranaJalanController extends Controller
{
    public function index()
    {
        $dataJalan = PrasaranaJalan::all();

        return view('prasaranaJalan', compact('dataJalan'));
    }
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $kabupaten = $request->get('kabupaten');

        $export = new PrasaranaJalanExport($kabupaten);

        $filename = 'prasarana_jalan.' . ($format === 'csv' ? 'csv' : ($format === 'pdf' ? 'pdf' : 'xlsx'));

        if ($format === 'csv') {
            return Excel::download($export, $filename, \Maatwebsite\Excel\Excel::CSV);
        }

        if ($format === 'pdf') {
            // OPTIONAL: implementasikan PDF export jika ingin
            return Excel::download($export, $filename, \Maatwebsite\Excel\Excel::DOMPDF);
        }

        return Excel::download($export, $filename);
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new PrasaranaJalanImport, $request->file('file'));

        return back()->with('success', 'Data Prasarana Jalan berhasil diimpor.');
    }
}
