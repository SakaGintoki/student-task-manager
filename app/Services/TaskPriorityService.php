<?php

namespace App\Services;

use Carbon\Carbon;

class TaskPriorityService
{
    /**
     * Menghitung prioritas tugas berdasarkan deadline.
     * Fungsi ini dirancang untuk White Box Testing (CFG Analysis).
     */
    public function calculateTaskPriority(?string $deadline): string
    {
        // Node 1: Cek apakah deadline kosong
        if (empty($deadline)) {
            return "Normal"; // Node 2
        }

        try {
            $deadlineDate = Carbon::parse($deadline);
            $now = Carbon::now();

            // Node 3: Cek apakah sudah lewat deadline
            if ($deadlineDate->isPast()) {
                return "Sangat Tinggi (Overdue)"; // Node 4
            }

            $diffInDays = $now->diffInDays($deadlineDate);

            // Node 5: Cek selisih hari
            if ($diffInDays <= 1) {
                return "Tinggi"; // Node 6
            } else if ($diffInDays <= 3) {
                return "Medium"; // Node 7
            } else {
                return "Rendah"; // Node 8
            }

        } catch (\Exception $e) {
            // Node 9: Error parsing
            return "Normal";
        }
    }
}
