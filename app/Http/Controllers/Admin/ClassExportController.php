<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SchoolClass;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class ClassExportController extends Controller {

    public function export() {
        $this->deleteOldFiles();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $this->addHeaders($sheet);
        $this->addData($sheet);
        $this->addFooter($sheet);

        $writer = new XlsxWriter($spreadsheet);
        \Storage::makeDirectory('export/classes');
        $relPath = "export/classes/classes-" . date('YmdHis') . ".xlsx";
        $writer->save("../storage/app/$relPath");
        return \Storage::download($relPath);
    }

    /**
     * @param Worksheet $sheet
     * @throws Exception
     */
    private function addHeaders(Worksheet $sheet) {
        $headers = [
            'NOMBRE INSCRIPTION',
            'LYCEE',
            'ADRESSE',
            'CODE POSTAL',
            'VILLE',
            'NOMPROF',
            'PRENOMPROF',
            'EMAIL',
            'CLASSE',
            'NOMBRE D\'ELEVES',
            'JANVIER',
            'MARS',
            'MAI',
            'FETE'
        ];
        $sheet->getRowDimension(1)->setRowHeight(50);
        for ($i = 0; $i < count($headers); $i++) {
            $letter = chr(65 + $i);
            $cell = $letter . '1';
            $sheet->setCellValue($cell, $headers[$i]);
            $sheet->getColumnDimension($letter)->setAutoSize(true);
        }
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:N1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('FFFCD5B4'));
        $sheet->getStyle('A1:N1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color(Color::COLOR_BLACK));
    }

    private function addData(Worksheet $sheet) {
        SchoolClass::all()->each(function (SchoolClass $class, $row) use ($sheet) {
            $row = $row + 2;
            $sheet->setCellValue("A$row", $class->id);
            $sheet->setCellValue("B$row", $class->school->name);
            $sheet->setCellValue("C$row", $class->school->address);
            $sheet->setCellValue("D$row", $class->school->postal_code);
            $sheet->setCellValue("E$row", $class->school->city);
            $sheet->setCellValue("F$row", $class->teacher->last_name);
            $sheet->setCellValue("G$row", $class->teacher->first_name);
            $sheet->setCellValue("H$row", $class->teacher->user->email);
            $sheet->setCellValue("I$row", $class->name);
            $sheet->setCellValue("J$row", $class->students);
            $sheet->setCellValue("K$row", $this->statusToString($class->status_january));
            $sheet->setCellValue("L$row", $this->statusToString($class->status_march));
            $sheet->setCellValue("M$row", $this->statusToString($class->status_may));
            $sheet->setCellValue("N$row", $this->statusToString($class->status_party));
            $sheet->getStyle("A$row:N$row")->getBorders()
                ->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
                ->setColor(new Color(Color::COLOR_BLACK));
            $sheet->getStyle("A$row")->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('FFFCD5B4'));
        });
    }

    /**
     * @param Worksheet $sheet
     * @throws Exception
     */
    private function addFooter(Worksheet $sheet) {
        $classes = SchoolClass::query()->count();
        $students = SchoolClass::query()->sum('students');
        $status_january = SchoolClass::query()->count('status_january');
        $status_march = SchoolClass::query()->count('status_march');
        $status_may = SchoolClass::query()->count('status_may');
        $status_party = SchoolClass::all()->pluck('status_party')->sum();

        $row = $classes + 1 + 3; // header + space after
        $sheet->setCellValue("I$row", $classes);
        $sheet->setCellValue("J$row", $students);
        $sheet->setCellValue("K$row", $status_january);
        $sheet->setCellValue("L$row", $status_march);
        $sheet->setCellValue("M$row", $status_may);
        $sheet->setCellValue("N$row", $status_party);

        $sheet->getStyle("A$row:N$row")->getBorders()
            ->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color(Color::COLOR_BLACK));
        $sheet->getStyle("A$row:N$row")->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('FFFCD5B4'));
        $sheet->getStyle("A$row:N$row")->getFont()->setBold(true);
        $sheet->getStyle("A$row:N$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $sheet->setAutoFilter('A1:N' . ($classes + 1));
    }

    private function statusToString($status) {
        if ($status == null)
            return "pas répondu";
        if ($status === 1)
            return "oui";
        if ($status === 0)
            return "non";
        return "";
    }

    private function deleteOldFiles() {
        Storage::delete(Storage::files('export/classes'));
    }
}
