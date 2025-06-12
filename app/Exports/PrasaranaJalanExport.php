<?php

namespace App\Exports;

use App\Models\PrasaranaJalan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrasaranaJalanExport implements FromCollection, WithHeadings
{
    protected $kabupaten;

    public function __construct($kabupaten = null)
    {
        $this->kabupaten = $kabupaten;
    }

    public function collection()
    {
        $query = PrasaranaJalan::select(
            'no_ruas',
            'kode_ruas',
            'nama_ruas',
            'kabupaten',
            'panjang_ruas_km',
            'panjang_survey_km',
            'lebar_ruas_m',
            'perkerasan_hotmix_km',
            'perkerasan_lapen_km',
            'perkerasan_beton_km',
            'telford_kerikil',
            'tanah_belum_tembus',
            'kondisi_baik_km',
            'kondisi_baik_persen',
            'kondisi_sedang_km',
            'kondisi_sedang_persen',
            'kondisi_rusak_ringan_km',
            'kondisi_rusak_ringan_persen',
            'kondisi_rusak_berat_km',
            'kondisi_rusak_berat_persen',
            'lhr',
            'akses',
            'keterangan'
        );

        if (!empty($this->kabupaten)) {
            $query->where('kabupaten', $this->kabupaten);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No Ruas',
            'Kode Ruas',
            'Nama Ruas',
            'Kabupaten',
            'Panjang Ruas (km)',
            'Panjang Survey (km)',
            'Lebar Ruas (m)',
            'Hotmix (km)',
            'Lapen (km)',
            'Beton (km)',
            'Telford/Kerikil (km)',
            'Tanah Belum Tembus (km)',
            'Baik (km)',
            'Baik (%)',
            'Sedang (km)',
            'Sedang (%)',
            'Rusak Ringan (km)',
            'Rusak Ringan (%)',
            'Rusak Berat (km)',
            'Rusak Berat (%)',
            'LHR',
            'Akses',
            'Keterangan'
        ];
    }
}
