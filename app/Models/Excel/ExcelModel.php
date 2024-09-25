<?php

namespace Models\Excel;

require '../vendor/autoload.php';

use Models\MasterModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ExcelModel extends MasterModel
{
    private $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }
    public function generateExcel(array $data, string $filename, int $startRow, int $startColumn, int $totalDocs, $subtotal, $iva, $total, ?string $templatePath = null)
    {
        if ($templatePath) {
            // Cargar la plantilla existente
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        } else {
            // Crear una nueva instancia de Spreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }

        // Obtener la hoja de cálculo activa
        $sheet = $spreadsheet->getActiveSheet();
        $endRow = $startRow + count($data) - 1;
        $endColumn = $startColumn + count($data[0]) - 1;

        // Ajustar ancho de las columnas al contenido
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        // Establecer bordes para el rango de datos
        $range = $sheet->getCellByColumnAndRow($startColumn, $startRow)
            ->getCoordinate() . ':' .
            $sheet->getCellByColumnAndRow($endColumn, $endRow)
            ->getCoordinate();
        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle($range)->applyFromArray($styleArray);

        // Set data
        $row = $startRow;
        foreach ($data as $item) {
            $column = $startColumn;
            foreach ($item as $value) {
                $sheet->setCellValueByColumnAndRow($column, $row, $value);
                $column++;
            }
            $row++;
        }

        $sheet->setCellValueByColumnAndRow(8, 7, 'Fecha del documento:');
        date_default_timezone_set('America/Bogota');
        $sheet->setCellValueByColumnAndRow(8, 8, date('Y-m-d H:i:s'));

        $sheet->setCellValueByColumnAndRow(9, 7, 'Total cotizaciones:');
        $sheet->setCellValueByColumnAndRow(9, 8, $totalDocs);

        $sheet->setCellValueByColumnAndRow(12, 7, 'Subtotal:');
        $sheet->setCellValueByColumnAndRow(12, 8, $subtotal);

        $sheet->setCellValueByColumnAndRow(13, 7, 'Impuestos:');
        $sheet->setCellValueByColumnAndRow(13, 8, $iva);

        $sheet->setCellValueByColumnAndRow(14, 7, 'Total:');
        $sheet->setCellValueByColumnAndRow(14, 8, $total);

        // styles
        $boldFontStyle = [
            'font' => [
                'bold' => true,
            ],
        ];

        $sheet->getStyleByColumnAndRow(8, 7)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(8, 8)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(9, 7)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(9, 8)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);

        $sheet->getStyleByColumnAndRow(12, 7)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(12, 8)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(13, 7)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(13, 8)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(14, 7)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);
        $sheet->getStyleByColumnAndRow(14, 8)->applyFromArray($styleArray)->applyFromArray($boldFontStyle);

        // Guardar el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $folder_path = 'uploads/reports/';
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0755, true);
        }
        $file = $folder_path . $filename . '.xlsx';
        $writer->save($file);
        return $file;
    }

    public function genereateExcelExportArticles(array $dataExport, string $filename, ?string $templatePath = null)
    {
        if (file_exists($templatePath)) {
            // Cargar la plantilla existente
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        } else {
            // Crear una nueva instancia de Spreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }

        $spreadsheet
            ->getProperties()
            ->setCreator("Business And Connection")
            ->setLastModifiedBy('Sanditor')
            ->setTitle("Reporte Artículos")
            ->setDescription("Reporte de todos los artículos");


        $itemSheet = $spreadsheet->getActiveSheet();
        $itemSheet->setTitle("Reporte Artículos");

        // Ajustar ancho de las columnas al contenido
        foreach ($itemSheet->getColumnIterator() as $column) {
            $itemSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $numeroDeFila = 2;

        # Encabezado de los productos
        $header = ["Id", "código", "Nombre", "Descripción", "Características", "Unidad Medida", "Color", "Categoría", "SubCategoría", "Estado"];

        # El último argumento es por defecto A1
        $itemSheet->fromArray($header, null, 'A1');

        // Obtener el estilo de la fila de encabezados (primera fila)
        $styleHeader = $itemSheet->getStyle('1:1');

        // Establecer la alineación horizontal en centrado para la fila de encabezados
        $styleHeader->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Establecer la propiedad de fuente en negrita para la fila de encabezados
        $fontHeader = $styleHeader->getFont();
        $fontHeader->setBold(true);        

        //iterar el array de datos
        for ($i = 0; $i < count($dataExport); $i++) {

            $ar_id =  $dataExport[$i]['ar_id'];
            $ar_code =  $dataExport[$i]['ar_code'];
            $ar_name =  $dataExport[$i]['ar_name'];
            $ar_desc =  $dataExport[$i]['ar_desc'];
            $ar_characteristics =  $dataExport[$i]['ar_characteristics'];
            $ar_und_med =  $dataExport[$i]['mt_name'];
            $ar_name_color =  $dataExport[$i]['color_name'];
            $ar_name_category =  $dataExport[$i]['cat_name'];
            $ar_name_subCategory =  $dataExport[$i]['sbcat_name'];
            $ar_status =  $dataExport[$i]['status_name'];
            $itemSheet->setCellValueByColumnAndRow(1, $numeroDeFila, $ar_id);
            $itemSheet->setCellValueByColumnAndRow(2, $numeroDeFila, $ar_code);
            $itemSheet->setCellValueByColumnAndRow(3, $numeroDeFila, $ar_name);
            $itemSheet->setCellValueByColumnAndRow(4, $numeroDeFila, $ar_desc);
            $itemSheet->setCellValueByColumnAndRow(5, $numeroDeFila, $ar_characteristics);
            $itemSheet->setCellValueByColumnAndRow(6, $numeroDeFila, $ar_und_med);
            $itemSheet->setCellValueByColumnAndRow(7, $numeroDeFila, $ar_name_color);
            $itemSheet->setCellValueByColumnAndRow(8, $numeroDeFila, $ar_name_category);
            $itemSheet->setCellValueByColumnAndRow(9, $numeroDeFila, $ar_name_subCategory);
            $itemSheet->setCellValueByColumnAndRow(10, $numeroDeFila, $ar_status);
            $numeroDeFila++;
        }

        // Guardar el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $folder_path = 'uploads/exports/';
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0755, true);
        }
        $nameFileSave =  $folder_path . $filename . '.xlsx';

        # Le pasamos la ruta de guardado
        $writer->save($nameFileSave);

        return $nameFileSave;
    }

    public function genereateExcelExportClients(array $dataExport, string $filename, ?string $templatePath = null)
    {
        if (file_exists($templatePath)) {
            // Cargar la plantilla existente
            $spreadsheetClients = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        } else {
            // Crear una nueva instancia de Spreadsheet
            $spreadsheetClients = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        }

        $spreadsheetClients
            ->getProperties()
            ->setCreator("Business And Connection")
            ->setLastModifiedBy('Sanditor')
            ->setTitle("Reporte Clientes")
            ->setDescription("Reporte de todos los clientes");


        $itemSheetClients = $spreadsheetClients->getActiveSheet();
        $itemSheetClients->setTitle("Reporte Clientes");

        // Ajustar ancho de las columnas al contenido
        foreach ($itemSheetClients->getColumnIterator() as $column) {
            $itemSheetClients->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $numeroDeFila = 2;

        # Encabezado de los productos
        $headerClients = ["Id", "Nombre", "Descripción", "NIT", "Digito NIT", "Dirección", "Dirección Compras", "Tipo Compañía", "Nombre Vendedor", "Estado"];

        # El último argumento es por defecto A1
        $itemSheetClients->fromArray($headerClients, null, 'A1');

        // Obtener el estilo de la fila de encabezados (primera fila)
        $styleHeaderClients = $itemSheetClients->getStyle('1:1');

        // Establecer la alineación horizontal en centrado para la fila de encabezados
        $styleHeaderClients->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Establecer la propiedad de fuente en negrita para la fila de encabezados
        $fontHeaderClients = $styleHeaderClients->getFont();
        $fontHeaderClients->setBold(true);        

        //iterar el array de datos
        for ($i = 0; $i < count($dataExport); $i++) {

            $c_id =  $dataExport[$i]['c_id'];
            $c_name =  $dataExport[$i]['c_name'];
            $c_desc =  $dataExport[$i]['c_desc'];
            $c_num_nit =  $dataExport[$i]['c_num_nit'];
            $c_num_ver_nit =  $dataExport[$i]['c_num_ver_nit'];
            $adress =  $dataExport[$i]['adress'];
            $adress_shipping =  $dataExport[$i]['adress_shipping'];
            $industry_name =  $dataExport[$i]['industry_name'];
            $s_name =  $dataExport[$i]['s_name'];
            $status_name =  $dataExport[$i]['status_name'];
            $itemSheetClients->setCellValueByColumnAndRow(1, $numeroDeFila, $c_id);
            $itemSheetClients->setCellValueByColumnAndRow(2, $numeroDeFila, $c_name);
            $itemSheetClients->setCellValueByColumnAndRow(3, $numeroDeFila, $c_desc);
            $itemSheetClients->setCellValueByColumnAndRow(4, $numeroDeFila, $c_num_nit);
            $itemSheetClients->setCellValueByColumnAndRow(5, $numeroDeFila, $c_num_ver_nit);
            $itemSheetClients->setCellValueByColumnAndRow(6, $numeroDeFila, $adress);
            $itemSheetClients->setCellValueByColumnAndRow(7, $numeroDeFila, $adress_shipping);
            $itemSheetClients->setCellValueByColumnAndRow(8, $numeroDeFila, $industry_name);
            $itemSheetClients->setCellValueByColumnAndRow(9, $numeroDeFila, $s_name);
            $itemSheetClients->setCellValueByColumnAndRow(10, $numeroDeFila, $status_name);
            $numeroDeFila++;
        }

        // Guardar el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheetClients);

        $folder_path = 'uploads/exports/';
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0755, true);
        }
        $nameFileSave =  $folder_path . $filename . '.xlsx';

        # Le pasamos la ruta de guardado
        $writer->save($nameFileSave);

        return $nameFileSave;
    }
}
