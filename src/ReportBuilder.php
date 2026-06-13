<?php

require_once '../src/Task.php';

class ReportBuilder
{
    public function build(array $tasks): array
    {
        $report = [];

        foreach ($tasks as $task) {

            $month = (int)$task->closedDate->format('n');
            $quarter = ceil($month / 3);
            $year = $task->closedDate->format('Y');

            if (!isset($report[$year])) {
                $report[$year] = [];
            }

            if (!isset($report[$year][$quarter])) {
                $report[$year][$quarter] = 0;
            }

            $report[$year][$quarter]++;
        }

        foreach ($report as $year => $quarters) {
            for ($quarter = 1; $quarter <= 4; $quarter++) {

                if (!isset($report[$year][$quarter])) {
                    $report[$year][$quarter] = 0;
                }
            }
            ksort($report[$year]);
        }

        return $report;
    }

    public function formatToText(array $calculatedData): string
    {
        $lines = [];

        foreach ($calculatedData as $year => $quarters) {
            foreach ($quarters as $q => $count) {
                $lines[] = "Q{$q} {$year} — {$count} закрытых задач";
            }
        }

        return implode("\n", $lines);
    }
}