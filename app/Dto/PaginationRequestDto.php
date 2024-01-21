<?php

declare(strict_types=1);

namespace App\Dto;

use Illuminate\Support\Collection;
class PaginationRequestDto
{
    public function __construct(
        public int $currentPage,
        public int $perPage,
        public int $total,
        public int $lastPage,
        public Collection $data,
    ) {
    }


}