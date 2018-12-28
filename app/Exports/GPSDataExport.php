<?php

namespace App\Exports;

use App\GPSData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GPSDataExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    private $gpsData;
    private $pricesPerEquipmentAndInstallation;

    public function __construct($data)
    {
        $this->gpsData = $data['gpsData'];
        $this->pricesPerEquipmentAndInstallation = $data['pricesPerEquipmentAndInstallation'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = array_merge($this->gpsData, [$this->pricesPerEquipmentAndInstallation]);
//        return $gpsData = new Collection($this->data);
        return new Collection($data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'шт.',
            'Тип',
            'Марка',
            'Модель',
            'Год выпуска',
            'Тип топлива',
            'Мощность',
            'Гос. номер',
            'GPS-трекер',
            'Цена $',
            'ДУТ',
            'Цена $',
            'Счетчик',
            'Цена $',
            'RFID',
            'Цена $',
            'Cчитыватель прицепного оборудования',
            'Цена $',
            'CAN',
            'Цена $',
            'Деаэратор малый',
            'Цена $',
            'Деаэратор большой',
            'Цена $',
            'CN03',
            'Цена $',
            'RS01',
            'Цена $',
            'Дополнительное оборудование',
            'Цена $',
            'Монтаж оборудования ₴'
        ];
    }
}
