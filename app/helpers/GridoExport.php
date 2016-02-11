<?php
namespace Helpers;

class GridoExport extends \Grido\Components\Export
{
    function send(\Nette\Http\IRequest $httpRequest, \Nette\Http\IResponse $httpResponse)
    {
		$fileName = $this->label . '.xlsx';
		$data = $this->grid->getData(FALSE);
		$columns = $this->grid[\Grido\Components\Columns\Column::ID]->getComponents();
		
		$objPHPExcel = new \PHPExcel();
		$header = $objPHPExcel->getActiveSheet();
		
		$i = 0;
		foreach ($columns as $column) {
			$header->setCellValueByColumnAndRow($i, 1, $column->getLabel());
			$i++;
		}


		$j = 1;
		foreach ($data as $item) {
			$j++;
			$items = array();
			$k = 0;
			foreach ($columns as $column) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($k, $j, $column->renderExport($item));
				$k++;
			}
		}
 
         // Save Excel 2007 file
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $file = TEMP_DIR . '/export/'.$this->label.'_'.date('Y-m-d-H-i-s').time().'.xlsx';		
		
		$objWriter->save($file);
		
		$source = file_get_contents($file);
		unlink($file);

		$httpResponse->setHeader('Content-type', 'application/octet-stream');
		$httpResponse->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"');
		$httpResponse->setHeader('Content-Transfer-Encoding', 'binary');
		$httpResponse->setHeader('Expires', '0');
		$httpResponse->setHeader('Pragma', 'no-cache');
		
		/*ob_start();
		$objWriter->save('php://output');
		$source = ob_get_clean();*/

		print $source;
    }
}