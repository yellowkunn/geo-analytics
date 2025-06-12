<?php

namespace App\Imports;

use App\Models\PrasaranaJalan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomStartRow;

class PrasaranaJalanImport implements ToModel, WithHeadingRow
{

    public function startRow(): int
    {
        return 8; // baris ke-8 (baris ke-7 index 0) adalah baris data sebenarnya
    }

    public function model(array $row)
    {
        return new PrasaranaJalan([
            'no_ruas'                       => $row['no_ruas'],
            'kode_ruas'                     => $row['kode_ruas'],
            'nama_ruas'                     => $row['nama_ruas'],
            'kabupaten'                     => $row['kabupaten'],
            'panjang_ruas_km'               => $row['panjang_ruas_km'],
            'panjang_survey_km'            => $row['panjang_survey_km'],
            'lebar_ruas_m'                  => $row['lebar_ruas_m'],
            'perkerasan_hotmix_km'          => $row['perkerasan_hotmix_km'],
            'perkerasan_lapen_km'           => $row['perkerasan_lapen_km'],
            'perkerasan_beton_km'           => $row['perkerasan_beton_km'],
            'telford_kerikil'              => $row['telford_kerikil'],
            'tanah_belum_tembus'           => $row['tanah_belum_tembus'],
            'kondisi_baik_km'              => $row['kondisi_baik_km'],
            'kondisi_baik_persen'          => $row['kondisi_baik_persen'],
            'kondisi_sedang_km'            => $row['kondisi_sedang_km'],
            'kondisi_sedang_persen'        => $row['kondisi_sedang_persen'],
            'kondisi_rusak_ringan_km'      => $row['kondisi_rusak_ringan_km'],
            'kondisi_rusak_ringan_persen'  => $row['kondisi_rusak_ringan_persen'],
            'kondisi_rusak_berat_km'       => $row['kondisi_rusak_berat_km'],
            'kondisi_rusak_berat_persen'   => $row['kondisi_rusak_berat_persen'],
            'lhr'                           => $row['lhr'],
            'akses'                         => $row['akses'],
            'keterangan'                    => $row['keterangan'],
        ]);
    }
}
