<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EventAttendanceController extends Controller
{
    public function exportExcel(Request $request, $id)
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
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $participants = $query->orderBy('name', 'asc')->get();
        $filterDate = $request->get('date');

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
                $attendance = $row->attendances->when($filterDate, function ($q) use ($filterDate) {
                    return $q->whereDate('attended_at', $filterDate);
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
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $participants = $query->orderBy('name', 'asc')->get();
        $filterDate = $request->get('date');

        return view('admin.events.print-attendance', compact('event', 'participants', 'filterDate'));
    }
}
