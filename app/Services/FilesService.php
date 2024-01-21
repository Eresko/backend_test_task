<?php

namespace App\Services;

use App\Models\File;
use App\Repository\FileRepository;
use App\Repository\FileElementRepository;
use App\Dto\PaginationRequestDto;

class FilesService
{

    public function __construct(
        private FileRepository $fileRepository,
        private PaginationService $paginationService,
        private RedisService $redisService,
    )
    {
    }

    /**
     * @param int $page
     * @return PaginationRequestDto
     */
    public function get(int $page = 1,string $search = ""):PaginationRequestDto
    {

        $files = $this->fileRepository->get($search);
        return $this->paginationService->toPagination($files,$page,3);
    }


    /**
     * @param int $id
     * @return File
     */
    public function fileContents(int $id):File {
        $file = $this->redisService->get($id);
        if ($file == null) {
            $file = $this->fileRepository->fileContents($id);
            $this->redisService->create($id,$file);
        }
        return $file;
    }
}