<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // Export ke CSV (bisa dibuka di Excel)
    public function exportExcel()
    {
        $data = Peminjaman::with(['peminjam', 'peralatan'])->get();
        
        $filename = 'data_peminjaman_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV (sesuai soal: siapa meminjam, barang apa, kapan)
        fputcsv($output, ['ID', 'Peminjam', 'Email Peminjam', 'Peralatan', 'Kode Peralatan', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status', 'Keterangan']);
        
        // Data
        foreach ($data as $row) {
            fputcsv($output, [
                $row->id,
                $row->peminjam->nama,
                $row->peminjam->email,
                $row->peralatan->nama,
                $row->peralatan->kode,
                $row->tanggal_pinjam,
                $row->tanggal_kembali ?? '-',
                $row->status == 'dipinjam' ? 'Dipinjam' : 'Dikembalikan',
                $row->keterangan ?? '-'
            ]);
        }
        
        fclose($output);
        exit;
    }

    // Export ke HTML (user bisa print to PDF via Ctrl+P)
    public function exportPdf()
    {
        $data = Peminjaman::with(['peminjam', 'peralatan'])->get();
        return view('exports.peminjaman_html', compact('data'));
    }
}