<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    // Fetch data
    public function collection()
    {
        $query = Booking::with(['user', 'van'])->orderBy('created_at', 'desc');

        if ($this->search) {
            $search = $this->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('van', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('start_date', 'like', "%{$search}%");
        }

        return $query->get();
    }

    // Headings for Excel
    public function headings(): array
    {
        return [
            'ID',
            'Van Name',
            'User Name',
            'User Email',
            'Start Date',
            'Return Date',
            'Total Days',
            'Total Price',
            'Booking Time',
            'Created At'
        ];
    }

    // Map each row
    public function map($booking): array
    {
        $start = \Carbon\Carbon::parse($booking->start_date);
        $end   = \Carbon\Carbon::parse($booking->end_date);
        $days  = $end->gte($start) ? $end->diffInDays($start) + 1 : 1;

        return [
            $booking->id,
            $booking->van->name ?? '-',
            $booking->user->name ?? '-',
            $booking->user->email ?? '-',
            $booking->start_date,
            $booking->end_date,
            $days,
            number_format($booking->total_price, 2),
            \Carbon\Carbon::parse($booking->time)->format('H:i'),
            $booking->created_at->format('Y-m-d H:i')
        ];
    }

    // Excel styling
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Auto-size columns
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Bold headings
                $sheet->getStyle('A1:J1')->getFont()->setBold(true);
            },
        ];
    }
}
