<?php

namespace App\Services;

use App\Dto\PaginationRequestDto;
use Illuminate\Support\Collection;
class PaginationService
{


    /**
     * @param Collection $data
     * @param int $currentPage
     * @param int $perPage
     * @return PaginationRequestDto
     */
    public function toPagination(Collection $data,int $currentPage = 1,int $perPage = 10):PaginationRequestDto
    {

        $currentPage = $currentPage < 0 ? 1 : $currentPage;
        $remainder = $data->count() % $perPage ? 1 : 0;
        return new PaginationRequestDto(
            $currentPage,
            $perPage,
            $data->count(),
            floor($data->count() / $perPage) + $remainder,
            $data->forPage($currentPage,$perPage)
        );

    }
}