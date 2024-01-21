<?php

namespace App\Repository;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
class FileRepository
{

    /**
     * @param string $name
     * @return File
     */
    public function createFile(string $name):File {

        return File::create(['name' => $name]);
    }


    /**
     * @return Collection
     */
    public function get(string $search):Collection {

        if (trim($search) == "") {
            return File::query()->get();
        }

        return File::query()->where("name",'LIKE','%'.$search.'%')->get();
    }

    /**
     * @param $id
     * @return File
     */
    public function fileContents($id):File {

        return File::query()->with("fileElement")->find($id);

    }


}