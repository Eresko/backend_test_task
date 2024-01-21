<?php

namespace App\Repository;

use App\Models\File;
use App\Models\FileElement;
use Illuminate\Database\Eloquent\Builder;
class FileElementRepository
{

    /**
     * @param File $file
     * @param array $datas
     * @return bool
     */
    public function createElement(File $file,array $datas):bool {

        if ((count($datas) == 0) || (empty($file))){
            return false;
        }
        foreach ($datas as $data) {
            FileElement::create(['file_id' => $file->id,'line' => json_encode($data)]);
        }
        return true;
    }


}