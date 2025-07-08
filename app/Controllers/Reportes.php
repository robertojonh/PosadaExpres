<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportesModel;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Reportes extends BaseController
{
    protected $model;
    protected $pdfconfig;
    public function __construct()
    {
        $this->model = new ReportesModel();
        $this->pdfconfig = array(
            ini_set("pcre.backtrack_limit", "1000000000"),
            'mode' => 'utf-8',
            'format' => [220, 280],
            'default_font_size' => 10,
            'default_font' => 'comic',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin-top' => 10,
            'mgt' => 0,
            'mgb' => 0,
            'margin_header' => 5,
            'margin_footer' => 10,
            'orientation' => 'P',
            'setAutoTopMargin' => 'stretch'
        );
    }

    public function excelRentas()
    {
        $rentas = $this->model->getRentas();
        $titulo = "Reporte de rentas";
        $fecha = 'Fecha: ' . date('d/m/Y');
        $rutaPlantilla = WRITEPATH . 'uploads/plantillas/plantilla_rentas.xlsx';
        $spreadsheet = IOFactory::load($rutaPlantilla);
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setCellValue('A4', $titulo);
        $hoja->setCellValue('A6', $fecha);
        $fila = 8;
        $hoja->fromArray(
            ['#', 'Número de habitación', 'Tipo renta', 'Número de noches', 'Precio', 'Observaciones', 'Entrada', 'Salida', 'Entrada sin formato', 'Salida sin formato', 'Liberación', 'Liberación sin formato'],
            null,
            'A' . $fila++
        );
        foreach ($rentas as $key => $value) {
            $hoja->setCellValue('A' . $fila, $key + 1);
            $hoja->setCellValue('B' . $fila, $value->num ?? '');
            $hoja->setCellValue(
                'C' . $fila,
                isset($value->tipo)
                    ? ($value->tipo == 2
                        ? 'Por noche'
                        : ($value->tipo == 1 ? 'Por horas' : '')
                    )
                    : ''
            );
            $hoja->setCellValue('D' . $fila, $value->num_noches ?? '');
            $hoja->setCellValue('E' . $fila, $value->total ?? '');
            $hoja->setCellValue('F' . $fila, $value->observaciones ?? '');
            $hoja->setCellValue('G' . $fila, formato_fecha($value->fecha_inicio, 3) ?? '');
            $hoja->setCellValue('H' . $fila, formato_fecha($value->fecha_fin, 3) ?? '');
            $hoja->setCellValue('I' . $fila, $value->fecha_inicio ?? '');
            $hoja->setCellValue('J' . $fila, $value->fecha_fin ?? '');
            $hoja->setCellValue('K' . $fila, formato_fecha($value->fecha_liberacion, 3) ?? '');
            $hoja->setCellValue('L' . $fila, $value->fecha_liberacion ?? '');
            $fila++;
        }

        $filename = 'Reporte_Rentas.xlsx';
        if (ob_get_length()) {
            ob_end_clean();
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function excelReservaciones()
    {
        $reservaciones = $this->model->getReservaciones();
        $titulo = "Reporte de reservaciones";
        $fecha = 'Fecha: ' . date('d/m/Y');
        $rutaPlantilla = WRITEPATH . 'uploads/plantillas/plantilla_reservaciones.xlsx';
        $spreadsheet = IOFactory::load($rutaPlantilla);
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setCellValue('A4', $titulo);
        $hoja->setCellValue('A6', $fecha);
        $fila = 8;
        $hoja->fromArray(
            ['#', 'Número de habitación', 'Precio', 'Entrada', 'Salida', 'Fecha entrada sin formato', 'Fecha salida sin formato'],
            null,
            'A' . $fila++
        );
        foreach ($reservaciones as $key => $value) {
            $hoja->setCellValue('A' . $fila, $key + 1);
            $hoja->setCellValue('B' . $fila, $value->num ?? '');
            $hoja->setCellValue('C' . $fila, $value->precio ?? '');
            $hoja->setCellValue('D' . $fila, formato_fecha($value->fecha_inicio, 3) ?? '');
            $hoja->setCellValue('E' . $fila, formato_fecha($value->fecha_fin, 3) ?? '');
            $hoja->setCellValue('F' . $fila, $value->fecha_inicio ?? '');
            $hoja->setCellValue('G' . $fila, $value->fecha_fin ?? '');
            $fila++;
        }

        $filename = 'Reporte_Reservaciones.xlsx';
        if (ob_get_length()) {
            ob_end_clean();
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Pragma: public');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
