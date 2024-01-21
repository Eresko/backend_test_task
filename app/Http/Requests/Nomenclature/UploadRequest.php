<?php

declare(strict_types=1);

namespace App\Http\Requests\Nomenclature;


use App\Http\Requests\BaseRequest;
use Illuminate\Support\Carbon;

class UploadRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|max:10000',
        ];
    }
}
