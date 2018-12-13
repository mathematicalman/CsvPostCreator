<?php
namespace CsvPostCreator\Models;

class FileParser
{
    /**
     * @param string $filename
     * @return array
     */
    public static function parseCsvFile($filename)
    {
        $data = [];
        if (($handle = fopen("$filename", "r")) !== false) {
            while (($row = fgetcsv($handle, 0, ",")) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }
        return $data;
    }
}
