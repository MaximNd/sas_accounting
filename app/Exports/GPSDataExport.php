<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

class GPSDataExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents, WithStrictNullComparison
{
    private $dollarRate;
    private $gpsData;
    private $pricesPerEquipmentAndInstallation;
    private $priceForAll;
    private $pricesTable;
    private $gruppedEquipment;

    public function __construct($data)
    {
        $this->dollarRate = $data['dollarRate'];
        $this->gpsData = $data['gpsData'];
        $this->pricesPerEquipmentAndInstallation = $data['pricesPerEquipmentAndInstallation'];
        $this->priceForAll = $data['priceForAll'];
        $this->pricesTable = $data['pricesTable'];
        $this->gruppedEquipment = $data['gruppedEquipment'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $lastIndex = 0;
        $pricesTableAndGruppedEquipment = [];
        for ($i = 0; $i < count($this->pricesTable); ++$i) {
            if ($i === 0) {
                $pricesTableAndGruppedEquipment[] = array_merge($this->pricesTable[$i], [null, null, null, 'Тип', 'шт.', 'Ціна']);
                continue;
            }
            $lastIndex = $i;
            $indexForGruppedEquipment = $i - 1;
            $pricesTableAndGruppedEquipment[] = array_merge(
                $this->pricesTable[$i], [null, null, null],
                [
                    isset($this->gruppedEquipment[$indexForGruppedEquipment]) ? $this->gruppedEquipment[$indexForGruppedEquipment]['type'] : null,
                    isset($this->gruppedEquipment[$indexForGruppedEquipment]) ? $this->gruppedEquipment[$indexForGruppedEquipment]['count'] : null,
                    isset($this->gruppedEquipment[$indexForGruppedEquipment]) ? $this->gruppedEquipment[$indexForGruppedEquipment]['price'] : null
                ]
            );
        }

        if ($lastIndex <= count($this->gruppedEquipment)) {
            $pricesTableAndGruppedEquipment = array_merge(
                $pricesTableAndGruppedEquipment,
                array_map(function ($row) {
                    return [
                        null, null, null, null, null,
                        $row['type'],
                        $row['count'],
                        $row['price']
                    ];
                },
                    array_slice(
                        $this->gruppedEquipment,
                        $lastIndex
                    )
                )
            );
        }



        $data = array_merge(
            $this->gpsData,
            [$this->pricesPerEquipmentAndInstallation],
            [$this->priceForAll],
            [[]],
            [[]],
            [[]],
            $pricesTableAndGruppedEquipment);
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
            'Рік випуску',
            'Тип палива',
            'Потужність',
            'Держ. номер',
            'GPS-трекер',
            'Ціна $',
            'ДУТ',
            'Ціна $',
            'Лічильник',
            'Ціна $',
            'RFID',
            'Ціна $',
            'Зчитувач причіпного обладнання',
            'Ціна $',
            'CAN',
            'Ціна $',
            'Деаератор малий',
            'Ціна $',
            'Деаератор великий',
            'Ціна $',
            'CN03',
            'Ціна $',
            'RS01',
            'Ціна $',
            'Додаткове обладнання',
            'Цена $',
            'Монтаж обладнання ₴'
        ];
    }

    private function setStylesToHeaders(Sheet $sheet) {
        $sheet->getDelegate()->getStyle('B1:AD1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => 'center'
            ],
            'borders' => [
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'color' => [
                    'argb' => 'F2F2F2'
                ]
            ]
        ]);
        $sheet->getDelegate()->getStyle('AE1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => 'right'
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'color' => [
                    'argb' => 'F2F2F2'
                ]
            ]
        ]);
        $sheet->getDelegate()->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => 'left'
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'color' => [
                    'argb' => 'F2F2F2'
                ]
            ]
        ]);
    }

    private function setStylesToGPSData(Sheet $sheet) {
        $topRowIndex = 2;
        $bottomRowIndex = count($this->gpsData) + 1;
        $sheet->getDelegate()->getStyle('A'.$topRowIndex.':D'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'left'
            ],
            'borders' => [
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ],
        ]);
        $sheet->getDelegate()->getStyle('E'.$topRowIndex.':AE'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'center'
            ],
            'borders' => [
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ],
        ]);
        $sheet->getDelegate()->getStyle('AE'.$topRowIndex.':AE'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'right'
            ]
        ]);
    }

    private function setStylesToPricesPerEquipmentAndInstallation(Sheet $sheet) {
        $rowIndex = count($this->gpsData) + 2;
        $columns = ['J', 'L', 'N', 'P', 'R', 'T', 'V', 'X', 'Z', 'AB', 'AD'];
        $sheet->getDelegate()->mergeCells('A'.$rowIndex.':B'.$rowIndex);
        $sheet->getDelegate()->getStyle('A'.$rowIndex.':AE'.$rowIndex)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'color' => ['argb' => 'D9D9D9']
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ]);
        $sheet->getDelegate()->getStyle('I'.$rowIndex.':AE'.$rowIndex)->applyFromArray([
            'borders' => [
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ],
        ]);
        $sheet->getDelegate()->getStyle('A'.$rowIndex)->applyFromArray([
            'font' => [
                'bold' => true,
                'italic' => true
            ],
            'alignment' => [
                'horizontal' => 'left'
            ]
        ]);
        $sheet->getDelegate()->getStyle('AE'.$rowIndex)->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => 'right'
            ]
        ]);
        foreach ($columns as $column) {
            $sheet->getDelegate()->setCellValueExplicit(
                $column.$rowIndex,
                '=SUMPRODUCT(A2:A'.($rowIndex-1).','.$column.'2:'.$column.($rowIndex-1).')',
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
            );
        }
        $sheet->getDelegate()->setCellValueExplicit(
            'AE'.$rowIndex,
            '=SUMPRODUCT(A2:A'.($rowIndex-1).',AE2:AE'.($rowIndex-1).')*(100-D29)%',
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
        );
    }

    private function setStylesToPriceForAll(Sheet $sheet) {
        $rowIndex = count($this->gpsData) + 3;
        $sheet->getDelegate()->mergeCells('A'.$rowIndex.':C'.$rowIndex);
        $sheet->getDelegate()->mergeCells('D'.$rowIndex.':AD'.$rowIndex);
        $sheet->getDelegate()->getStyle('A'.$rowIndex.':B'.$rowIndex)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => '538DD5']
            ]
        ]);
        $sheet->getDelegate()->getStyle('AE'.$rowIndex)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => '538DD5']
            ]
        ]);
        $sheet->getDelegate()->getStyle('A'.$rowIndex.':AE'.$rowIndex)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ]);
        $sheet->getDelegate()->setCellValueExplicit(
            'AE'.$rowIndex,
            '=SUM(D30:D31,D34,D38)',
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
        );
    }

    private function setStylesToPricesTable(Sheet $sheet) {
        $gpsDataLength = count($this->gpsData);
        $pricesTableLength = count($this->pricesTable);
        $topRowIndex = $gpsDataLength + 7;
        $bottomRowIndex = $topRowIndex + $pricesTableLength - 1;
        $sumsRowIndex = $gpsDataLength + 2;
        for ($i = 0; $i < $pricesTableLength; ++$i) {
            $sheet->getDelegate()->mergeCells('A'.($topRowIndex+$i).':C'.($topRowIndex+$i));
        }
        $sheet->getDelegate()->getStyle('A'.$topRowIndex.':D'.$bottomRowIndex)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ]);
        $sheet->getDelegate()->getStyle('A'.$topRowIndex.':C'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'left'
            ],
            'font' => [
                'bold' => true,
                'italic' => true,
                'size' => 12
            ]
        ]);
        $sheet->getDelegate()->getStyle('D'.$topRowIndex.':D'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'center'
            ],
            'font' => [
                'size' => 11
            ]
        ]);
        $sheet->getDelegate()->setCellValueExplicit(
            'D30',
            '=AE'.($gpsDataLength + 2),
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
        );
        $sheet->getDelegate()->setCellValueExplicit(
            'D31',
            '=(SUM(J'.$sumsRowIndex.':AD'.$sumsRowIndex.')*(100-D28)%)*'.$this->dollarRate,
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
        );
        $sheet->getDelegate()->setCellValueExplicit(
            'D34',
            '=D32*D33',
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
        );
        $sheet->getDelegate()->setCellValueExplicit(
            'D38',
            '=(D35*D36)*D37',
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA
        );
    }

    private function setStylesToGruppedEquipment(Sheet $sheet) {
        $gpsDataLength = count($this->gpsData);
        $gruppedEquipmentLength = count($this->gruppedEquipment);
        $topRowIndex = $gpsDataLength + 7;
        $bottomRowIndex = $topRowIndex + $gruppedEquipmentLength;
        $sheet->getDelegate()->getStyle('H'.$topRowIndex.':J'.$bottomRowIndex)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000']
                ]
            ]
        ]);
        $sheet->getDelegate()->getStyle('H'.$topRowIndex.':J'.$topRowIndex)->applyFromArray([
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '00000000']
                ]
            ],
            'font' => [
                'bold' => true
            ]
        ]);
        $sheet->getDelegate()->getStyle('H'.$topRowIndex.':H'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'left'
            ]
        ]);
        $sheet->getDelegate()->getStyle('I'.$topRowIndex.':J'.$bottomRowIndex)->applyFromArray([
            'alignment' => [
                'horizontal' => 'right'
            ]
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $this->setStylesToHeaders($event->sheet);
                $this->setStylesToGPSData($event->sheet);
                $this->setStylesToPricesPerEquipmentAndInstallation($event->sheet);
                $this->setStylesToPriceForAll($event->sheet);
                $this->setStylesToPricesTable($event->sheet);
                $this->setStylesToGruppedEquipment($event->sheet);
            }
        ];
    }
}
