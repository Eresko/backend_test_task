<?php

namespace App\Services;

use App\Repository\FileRepository;
use App\Repository\FileElementRepository;
class BaseFileService
{

    public function __construct(
        private FileRepository $fileRepository,
        private FileElementRepository $fileElementRepository,
    ) {
    }

    /**
     * @param object $file
     * @return bool
     */
    public function encodeFileCsv(object $file):bool
    {

        $nameFile = date("Y-m-d-H-i-s") . '_' . (string)$file->getClientOriginalName();
        $originalName = $file->getClientOriginalName();
        $file->move(base_path()."/storage",base_path()."/storage/".$nameFile);
        $dateCsv = $this->parseFile(base_path()."/storage/".$nameFile);
        $fileBase = $this->fileRepository->createFile($originalName);
        return $this->fileElementRepository->createElement($fileBase,$this->separator($dateCsv));
    }


    /**
     * @param string $path
     * @return array
     */
    private function parseFile(string $path):array {
        $handle = @fopen($path, "r");
        $dateCsv = [];
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $dateCsv[] = str_replace([","], "", $buffer);
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }
        unlink($path);

        return $dateCsv;
    }



    /**
     * @param array $dateCsv
     * @return array
     */
    private function separator(array $dateCsv):array {
        foreach ($dateCsv as &$elementDateCsv) {
            $elementDateCsv = explode(";",$elementDateCsv);
        }
        unset($elementDateCsv);
        return $dateCsv;
    }


}
