<?php
set_time_limit(0);

use ChatVo\ToolCrawler\Sites\Appliancesradar;
use ChatVo\ToolCrawler\Sites\Site;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include 'vendor/autoload.php';

// $links = (new Appliancesradar())->getLinks('https://appliancesradar.com/vacuums-and-floor-care/');

function exportExcel(Site $site)
{
    $categories = $site->getCategories();
    foreach ($categories as $category) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $name = basename($category);

        $links = $site->getLinks($category);
        foreach ($links as $key => $link) {
            $sheet->setCellValue('A'. $key+1, $site->getKeyWord($link));
            // $sheet->setCellValue('B'. $key+1, 'Hello World !');
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($name.'.xlsx');
    }
}

exportExcel((new Appliancesradar()));