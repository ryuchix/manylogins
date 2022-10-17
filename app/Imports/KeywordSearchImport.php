<?php

namespace App\Imports;

use App\Models\KeywordSearch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class KeywordSearchImport implements ToModel, WithCustomCsvSettings, WithUpserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        return new KeywordSearch([
            'keywords'     => $row[0],
            'slug'    => self::clean($row[0]),
            'status' => NULL,
            'api_result' => NULL,
        ]);
        
    }
    
    public function chunkSize(): int
    {
        return 500;
    }

    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
    }

    public function uniqueBy()
    {
        return 'keywords';
    }
}
