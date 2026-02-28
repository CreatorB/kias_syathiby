<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EventAttendanceController extends Controller
{
    public function exportCsv(Request $request, $id)
    {
        [$event, $participants, $filterDate] = $this->buildExportData($request, $id);

        $csvFileName = 'absensi_' . \Str::slug($event->title) . '_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($participants, $event, $filterDate) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['No', 'Nama', 'Email', 'No HP', 'Jenis Kelamin', 'Status Kehadiran', 'Waktu Hadir']);

            // Data
            foreach ($participants as $index => $row) {
                $attendance = $row->attendances->filter(function ($attendance) use ($filterDate) {
                    if (!$filterDate) {
                        return true;
                    }
                    return $attendance->attended_at->format('Y-m-d') === $filterDate;
                })->first();

                $status = $attendance ? 'Hadir' : 'Belum Hadir';
                $time = $attendance ? $attendance->attended_at->format('H:i') : '-';
                $gender = $row->gender; // Database stores 'Laki-Laki' or 'Perempuan' directly

                fputcsv($file, [
                    $index + 1,
                    $row->name,
                    $row->email,
                    $row->phone,
                    $gender,
                    $status,
                    $time
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request, $id)
    {
        [$event, $participants, $filterDate] = $this->buildExportData($request, $id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Absensi');

        $headers = ['No', 'Nama', 'Email', 'No HP', 'Jenis Kelamin', 'Status Kehadiran', 'Waktu Hadir'];
        $sheet->fromArray($headers, null, 'A1');

        $rowIndex = 2;
        foreach ($participants as $index => $participant) {
            $attendance = $participant->attendances->filter(function ($attendance) use ($filterDate) {
                if (!$filterDate) {
                    return true;
                }
                return $attendance->attended_at->format('Y-m-d') === $filterDate;
            })->first();

            $sheet->fromArray([
                $index + 1,
                $participant->name,
                $participant->email,
                $participant->phone,
                $participant->gender,
                $attendance ? 'Hadir' : 'Belum Hadir',
                $attendance ? $attendance->attended_at->format('H:i') : '-',
            ], null, 'A' . $rowIndex);

            $rowIndex++;
        }

        $lastDataRow = max(2, $rowIndex - 1);

        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF28C76F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:G' . $lastDataRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:A' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G2:G' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $fileName = 'absensi_' . \Str::slug($event->title) . '_' . date('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    private function buildExportData(Request $request, $id): array
    {
        $event = Event::findOrFail($id);
        $query = EventRegistration::with('attendances')
            ->where('event_id', $id)
            ->where('payment_status', 'valid');

        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                    ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($searchTerm) . '%']);
            });
        }

        $participants = $query->orderBy('name', 'asc')->get();
        $filterDate = $request->get('date');

        return [$event, $participants, $filterDate];
    }

    public function print(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $query = EventRegistration::with('attendances')
            ->where('event_id', $id)
            ->where('payment_status', 'valid');

        // Apply filters
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchTerm) . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($searchTerm) . '%']);
            });
        }

        $participants = $query->orderBy('name', 'asc')->get();
        $filterDate = $request->get('date');

        return view('admin.events.print-attendance', compact('event', 'participants', 'filterDate'));
    }
}
