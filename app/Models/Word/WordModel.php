<?php

namespace Models\Word;

require '../vendor/autoload.php';

use Models\MasterModel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;

class WordModel extends MasterModel
{
    private $phpWord;

    public function __construct()
    {
        $this->phpWord = new PhpWord();
    }

    public function generateWord(array $data, string $filename)
    {
        $section = $this->phpWord->addSection();
        $section->addText('Data', ['bold' => true, 'size' => 16]);

        // Set headers
        $headers = array_keys($data[0]);
        $table = $section->addTable();
        $table->addRow();
        foreach ($headers as $header) {
            $table->addCell()->addText($header, ['bold' => true]);
        }

        // Set data
        foreach ($data as $item) {
            $table->addRow();
            foreach ($item as $value) {
                $table->addCell()->addText($value);
            }
        }

        $folder_path = 'uploads/word/';
        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0755, true);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        $objWriter->save($folder_path . $filename . '.docx');
    }
}
?>