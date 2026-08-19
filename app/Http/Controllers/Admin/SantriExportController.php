<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Santri;
use App\Providers\StatusProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SantriExportController extends Controller
{
    public function exportCsv(Request $request)
    {
        [$santris, $tahunPsb] = $this->buildExportData($request);

        $fileName = 'data-santri-' . ($tahunPsb ? \Str::slug($tahunPsb) : date('Y')) . '-' . date('Ymd') . '.csv';
        $headers = [
            'Content-type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($santris) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8 detection
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            // Header
            fputcsv($file, [
                'Kode Registrasi', 'Tahun PSB', 'Nama Lengkap', 'NIK', 'NISN', 'Jenis Kelamin',
                'Tempat Lahir', 'Tanggal Lahir', 'No WA', 'Email', 'Alamat',
                'Pendidikan Terakhir', 'Pekerjaan', 'Program',
                'Nama Ayah', 'No HP Ayah', 'Nama Ibu', 'No HP Ibu', 'Nama Wali', 'No HP Wali',
                'Status Pendaftaran', 'Alasan Tolak Pendaftaran',
                'Status Transfer', 'Alasan Tolak Transfer', 'Nominal Transfer (Rp)',
                'Tgl Verifikasi', 'Pas Foto', 'KTP', 'Ijazah', 'Bukti Transfer', 'Tgl Daftar',
            ], ';');

            foreach ($santris as $s) {
                $noHp = trim(($s->kode_negara ?? '') . ($s->no_hp ?? ''));
                $ttl = $s->tmp_lahir ? $s->tmp_lahir : '';
                if ($s->tgl_lahir) {
                    $tglStr = $this->formatDate($s->tgl_lahir, 'Y-m-d');
                    $ttl .= ($ttl ? ', ' : '') . $tglStr;
                }
                fputcsv($file, [
                    $s->kode_registrasi,
                    $s->tahun_psb,
                    $s->nama,
                    $s->nik,
                    $s->nisn,
                    $s->jk,
                    $s->tmp_lahir,
                    $this->formatDate($s->tgl_lahir, 'Y-m-d'),
                    $noHp,
                    $s->email,
                    $s->alamat,
                    $s->pendidikan,
                    $s->pekerjaan,
                    $s->program?->nama_program,
                    $s->nama_ayah,
                    $s->no_hp_ayah,
                    $s->nama_ibu,
                    $s->no_hp_ibu,
                    $s->nama_wali,
                    $s->no_hp_wali,
                    $s->status_pendaftaran,
                    $s->alasan_penolakan,
                    $s->status_transfer,
                    $s->alasan_penolakan_transfer,
                    $s->nominal_transfer,
                    $this->formatDate($s->tgl_verifikasi, 'Y-m-d H:i:s'),
                    $s->photo ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->photo) : '',
                    $s->ktp ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->ktp) : '',
                    $s->ijazah ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->ijazah) : '',
                    $s->transfer ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->transfer) : '',
                    $this->formatDate($s->created_at, 'Y-m-d H:i:s'),
                ], ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        [$santris, $tahunPsb] = $this->buildExportData($request);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Santri');

        $headers = [
            'Kode Registrasi', 'Tahun PSB', 'Nama Lengkap', 'NIK', 'NISN', 'Jenis Kelamin',
            'Tempat Lahir', 'Tanggal Lahir', 'No WA', 'Email', 'Alamat',
            'Pendidikan Terakhir', 'Pekerjaan', 'Program',
            'Nama Ayah', 'No HP Ayah', 'Nama Ibu', 'No HP Ibu', 'Nama Wali', 'No HP Wali',
            'Status Pendaftaran', 'Alasan Tolak Pendaftaran',
            'Status Transfer', 'Alasan Tolak Transfer', 'Nominal Transfer (Rp)',
            'Tgl Verifikasi', 'Pas Foto', 'KTP', 'Ijazah', 'Bukti Transfer', 'Tgl Daftar',
        ];
        $sheet->fromArray($headers, null, 'A1');

        $rowIndex = 2;
        foreach ($santris as $s) {
            $noHp = trim(($s->kode_negara ?? '') . ($s->no_hp ?? ''));
            $sheet->fromArray([
                $s->kode_registrasi,
                $s->tahun_psb,
                $s->nama,
                $s->nik,
                $s->nisn,
                $s->jk,
                $s->tmp_lahir,
                $this->formatDate($s->tgl_lahir, 'Y-m-d'),
                $noHp,
                $s->email,
                $s->alamat,
                $s->pendidikan,
                $s->pekerjaan,
                $s->program?->nama_program,
                $s->nama_ayah,
                $s->no_hp_ayah,
                $s->nama_ibu,
                $s->no_hp_ibu,
                $s->nama_wali,
                $s->no_hp_wali,
                $s->status_pendaftaran,
                $s->alasan_penolakan,
                $s->status_transfer,
                $s->alasan_penolakan_transfer,
                $s->nominal_transfer,
                $this->formatDate($s->tgl_verifikasi, 'Y-m-d H:i:s'),
                $s->photo ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->photo) : '',
                $s->ktp ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->ktp) : '',
                $s->ijazah ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->ijazah) : '',
                $s->transfer ? url('uploads/' . $s->tahun_psb . '/' . $s->kode_registrasi . '/' . $s->transfer) : '',
                $this->formatDate($s->created_at, 'Y-m-d H:i:s'),
            ], null, 'A' . $rowIndex);
            $rowIndex++;
        }

        $lastDataRow = max(2, $rowIndex - 1);

        $sheet->getStyle('A1:AE1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF28C76F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:AE' . $lastDataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:F' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'AE') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $fileName = 'data-santri-' . ($tahunPsb ? \Str::slug($tahunPsb) : date('Y')) . '-' . date('Ymd') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function exportVcf(Request $request)
    {
        [$santris, $tahunPsb] = $this->buildExportData($request);

        $programMap = $this->getProgramCodeMap();

        $cards = [];
        foreach ($santris as $s) {
            $genderLetter = ($s->jk === 'Laki-Laki') ? 'L' : (($s->jk === 'Perempuan') ? 'P' : 'X');
            $programName = $s->program?->nama_program ?? '';
            $code = $this->resolveProgramCode($programName, $programMap);
            $tahunShort = '';
            if ($s->tahun_psb) {
                // tahun_psb is like "2026/2027" — take first 4 chars' last 2
                $tahunShort = substr((string) $s->tahun_psb, 2, 2);
            }
            if (!$tahunShort) {
                $tahunShort = substr((string) date('Y'), -2);
            }
            $displayName = $code . $tahunShort . $genderLetter . ' ' . $s->nama;

            $hp = '';
            if ($s->hp) {
                $hp = '+' . ltrim($s->hp, '+');
            } elseif ($s->kode_negara || $s->no_hp) {
                $hp = '+' . trim(($s->kode_negara ?? '') . ($s->no_hp ?? ''));
            }

            $org = $code . $tahunShort;
            $programShort = $programName ? trim(explode(' ', $programName)[0]) : 'Mahasantri';

            $card = "BEGIN:VCARD\r\n";
            $card .= "VERSION:3.0\r\n";
            $card .= "FN:" . $this->esc($displayName) . "\r\n";
            $card .= "N:" . $this->esc($displayName) . ";;;;\r\n";
            $card .= "ORG:" . $this->esc($org) . "\r\n";
            $card .= "NICKNAME:" . $this->esc($programShort . ' [' . ($s->kode_registrasi ?? '') . ']') . "\r\n";
            if ($s->tgl_lahir) {
                $tgl = $this->formatDate($s->tgl_lahir, 'Y-m-d');
                $card .= "BDAY:" . str_replace('-', '', $tgl) . "\r\n";
            }
            if ($s->email) {
                $card .= "EMAIL;TYPE=INTERNET:" . $this->esc($s->email) . "\r\n";
            }
            if ($hp) {
                $card .= "TEL;TYPE=CELL:" . $this->esc($hp) . "\r\n";
            }
            if ($s->no_hp_ayah) {
                $card .= "TEL;TYPE=CELL:" . $this->esc($s->no_hp_ayah) . "\r\n";
            }
            if ($s->no_hp_ibu) {
                $card .= "TEL;TYPE=CELL:" . $this->esc($s->no_hp_ibu) . "\r\n";
            }
            if ($s->no_hp_wali) {
                $card .= "TEL;TYPE=CELL:" . $this->esc($s->no_hp_wali) . "\r\n";
            }
            if ($s->nama_ayah) {
                $card .= "X-ayah:" . $this->esc($s->nama_ayah) . "\r\n";
            }
            if ($s->nama_ibu) {
                $card .= "X-ibu:" . $this->esc($s->nama_ibu) . "\r\n";
            }
            if ($s->nama_wali) {
                $card .= "X-wali:" . $this->esc($s->nama_wali) . "\r\n";
            }
            if ($s->tmp_lahir) {
                $card .= "ADR;TYPE=HOME:;;" . $this->esc($s->tmp_lahir) . ";;;;\r\n";
            }
            $card .= "END:VCARD\r\n";

            $cards[] = $card;
        }

        $body = implode('', $cards);
        $fileName = 'Mahasantri_KIAS_' . date('Ymd') . '.vcf';

        return Response::make($body, 200, [
            'Content-Type'        => 'text/x-vcard; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control'       => 'no-store',
        ]);
    }

    private function esc(string $v): string
    {
        return str_replace(["\\", "\n", "\r", ',', ';'], ['\\\\', '\\n', '', '\\,', '\\;'], $v);
    }

    private function formatDate($v, string $format = 'Y-m-d H:i:s'): string
    {
        if (!$v) return '';
        if (is_string($v)) return $v;
        return $v->format($format);
    }

    /**
     * Program name → VCF code map.
     * For KIAS, the code prefixes are: Tajwid=Tq, B.Arab=Reg, Takmili=Tak.
     * For Mahadaly (single Hukum Keluarga Islam program), we still export
     * any rows with the Aly prefix when running there.
     */
    private function getProgramCodeMap(): array
    {
        // Build a map of program_nama_program (lowercased) → 2-3 char code
        return [
            'tajwid'                       => 'Tq',
            'bahasa arab'                  => 'Reg',
            'takmili'                      => 'Tak',
            'ulum syariah'                 => 'Usy',
            'hukum keluarga islam'         => 'Aly',
            'hukum keluarga islam (hki)'   => 'Aly',
        ];
    }

    private function resolveProgramCode(string $programName, array $map): string
    {
        $lower = strtolower($programName);
        foreach ($map as $needle => $code) {
            if (str_contains($lower, $needle)) {
                return $code;
            }
        }
        // Fallback: first 2-3 letters of first word, lowercased first letter then upper
        $words = preg_split('/\s+/', trim($programName));
        $first = $words[0] ?? 'Mahasantri';
        $fallback = strtoupper(substr($first, 0, 1)) . strtolower(substr($first, 1, 1));
        return substr($fallback, 0, 3);
    }

    private function buildExportData(Request $request): array
    {
        $tahunPsb = $request->get('tahun') ?: ($request->get('filterTahun') ?: null);
        $filterData = [
            'tahunPsb'    => $tahunPsb,
            'program'     => $request->get('program') ?: $request->get('filterProgram') ?: null,
            'jk'          => $request->get('jk') ?: $request->get('filterJk') ?: null,
            'namaSantri'  => $request->get('search') ?: $request->get('cariSantri') ?: null,
            'status'      => $request->get('status') ?: null,
        ];

        $query = Santri::queryPendaftaran($tahunPsb, $filterData);
        // Mirror data-santri: only those with Valid transfer
        $query->where('status_transfer', StatusProvider::TRANSFER_VALID);
        $query->orderBy('nama', 'asc');

        $santris = $query->get();

        return [$santris, $tahunPsb];
    }
}