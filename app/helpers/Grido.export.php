<?php
namespace Grido\Components;

/**
 * Changes delimiter of data export to CSV.
 *
 * @package     Grido
 * @subpackage  Components
 */
class ExcelDelimiterExport extends Export
{
    /**
     * @param array $data
     * @param \Nette\ComponentModel\RecursiveComponentIterator $columns
     * @return string
     */
    protected function generateCsv($data, \Nette\ComponentModel\RecursiveComponentIterator $columns)
    {
        $head = array();
        foreach ($columns as $column) {
            $head[] = $column->getLabel();
        }

        $resource = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+'); // 5MB of memory allocated
        fputcsv($resource, $head, ';');

        foreach ($data as $item) {
            $items = array();
            foreach ($columns as $column) {
                $items[] = $column->renderExport($item);
            }

            fputcsv($resource, $items, ';');
        }

        rewind($resource);
        $output = stream_get_contents($resource);
        fclose($resource);

        return $output;
    }
}
