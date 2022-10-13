<?php
set_time_limit(0);
ini_set("output_buffering", 1);
ini_set("zlib.output_compression", 0);
ini_set("implicit_flush", 1);

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use ChatVo\ToolCrawler\Sites\TestSite;
use ChatVo\ToolCrawler\Sites\Site;
use ChatVo\ToolCrawler\Sites\Appliancesradar;

include 'vendor/autoload.php';

// $links = (new Appliancesradar())->getLinks('https://appliancesradar.com/vacuums-and-floor-care/');

function exportExcel(Site $site)
{
    $categories = $site->getCategories();
    foreach ($categories as $key => $category) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $name = basename($category);

        $links = $site->getLinks($category);
        echo 'starting excel...'."\n";
        foreach ($links as $key => $link) {
            $sheet->setCellValue('A'. $key+1, $site->getKeyWord($link));
            // $sheet->setCellValue('B'. $key+1, 'Hello World !');
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($name.'.xlsx');
        echo 'Done------------------------'."\n";
    }
}

exportExcel((new Appliancesradar()));
// exportExcel(new TestSite());