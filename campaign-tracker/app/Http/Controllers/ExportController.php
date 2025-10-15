<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function surveysCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="surveys.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID','Date','Support Level','Supporters','Zone','Area','Station','Entered By']);
            Survey::with(['user','pollingStation.electoralArea.zone'])->chunk(1000, function ($batch) use ($handle) {
                foreach ($batch as $s) {
                    fputcsv($handle, [
                        $s->id,
                        optional($s->survey_date)->format('Y-m-d'),
                        $s->support_level,
                        $s->supporters_count,
                        optional($s->pollingStation->electoralArea->zone)->zone_code,
                        optional($s->pollingStation->electoralArea)->area_code,
                        optional($s->pollingStation)->station_code,
                        optional($s->user)->email,
                    ]);
                }
            });
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
