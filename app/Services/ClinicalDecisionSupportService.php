<?php

namespace App\Services;

use App\Models\MedicalRecord;

class ClinicalDecisionSupportService
{
    /**
     * Analyze the medical record and return insights using Python.
     *
     * @param MedicalRecord $record
     * @return array
     */
    public static function analyze(MedicalRecord $record): array
    {
        $alerts = [];
        $vitalSigns = $record->vital_signs;

        if (!$vitalSigns) {
            return $alerts;
        }

        try {
            $jsonInput = json_encode($vitalSigns);
            $scriptPath = base_path('app/Python/clinical_analysis.py');
            
            $process = new \Symfony\Component\Process\Process(['python3', $scriptPath, $jsonInput]);
            $process->run();

            if (!$process->isSuccessful()) {
                \Illuminate\Support\Facades\Log::error("CDSS Python Error: " . $process->getErrorOutput());
                return [];
            }

            $output = $process->getOutput();
            if ($output) {
                $alerts = json_decode($output, true);
                if (!is_array($alerts)) {
                    return [];
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("CDSS Python Exception: " . $e->getMessage());
            return [];
        }

        return $alerts;
    }
}
