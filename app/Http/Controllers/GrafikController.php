<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrasaranaJalan;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        $kabupaten = $request->get('kabupaten');

        $query = PrasaranaJalan::query();
        if ($kabupaten) {
            $query->where('kabupaten', $kabupaten);
        }

        $data = $query->get();

        $grafik = [
            'kondisi' => [
                'labels' => ['Baik', 'Sedang', 'Rusak Ringan', 'Rusak Berat'],
                'values' => [
                    (float) $data->sum('kondisi_baik_km'),
                    (float) $data->sum('kondisi_sedang_km'),
                    (float) $data->sum('kondisi_rusak_ringan_km'),
                    (float) $data->sum('kondisi_rusak_berat_km'),
                ]
            ],
            'perkerasan' => [
                'labels' => ['Hotmix', 'Lapen', 'Beton', 'Telford/Kerikil', 'Tanah Belum Tembus'],
                'values' => [
                    $data->sum('perkerasan_hotmix_km'),
                    $data->sum('perkerasan_lapen_km'),
                    $data->sum('perkerasan_beton_km'),
                    $data->sum('telford_kerikil'),
                    $data->sum('tanah_belum_tembus'),
                ]
            ],
            'persentase' => [
                'labels' => ['Baik %', 'Sedang %', 'Rusak Ringan %', 'Rusak Berat %'],
                'values' => [
                    $data->avg('kondisi_baik_persen'),
                    $data->avg('kondisi_sedang_persen'),
                    $data->avg('kondisi_rusak_ringan_persen'),
                    $data->avg('kondisi_rusak_berat_persen'),
                ]
            ],
        ];

        $kabupatenList = PrasaranaJalan::select('kabupaten')->distinct()->pluck('kabupaten');
        return view('grafik', compact('grafik', 'kabupaten', 'kabupatenList'));
    }
}
