<?php

namespace App\Modules;

use Exception;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    public static function read($file)
    {
        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            $data = [];
            for ($row = 1; $row <= $highestRow; $row++) {
                $cellValue = $sheet->getCell('A' . $row)->getValue();

                $data[] = "0".intval($cellValue);
            }
            return $data;
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
