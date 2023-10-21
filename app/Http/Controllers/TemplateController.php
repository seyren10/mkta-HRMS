<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class TemplateController extends Controller
{
    public static function tardiness($document_data)
    {
        $templatePath = public_path('Templates/imports/Template_Tardiness.docx');
        $outputPath = public_path('Templates/exports/' . Str::snake($document_data['full_name']) . '_tardiness.docx');

        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('employee_full_name', Str::of($document_data['full_name'])->upper());
        $templateProcessor->setValue('date', Carbon::now()->format('F j, Y'));

        $replacements = [
            ['line' => now()->addDays(-4)->format('F j, Y') . 'tae'],
            ['line' => now()->addDays(-2)->format('F j, Y')],
            ['line' => now()->format('F j, Y')]
        ];
        $templateProcessor->cloneBlock('lines', 0, true, false, $replacements);
        $templateProcessor->setValue('disciplinary_action', $document_data["disciplinary_action"]);
        $templateProcessor->setValue('attempts', $document_data["attempts"]);

        $templateProcessor->saveAs($outputPath);

        // return response()->download($outputPath)->deleteFileAfterSend(true);
        return $outputPath;
    }
}
