<?php

namespace App\Http\Controllers\Nomenclature;

use App\Http\Requests\Nomenclature\UploadRequest;
use Illuminate\Http\Request;
use App\Services\BaseFileService;

class UploadController {

    public function __construct(
        private BaseFileService $baseFileService,
    ) {
    }
    /**
     * @OA\Post(
     *     path="/api/nomenclature/upload-file",
     *     tags={"Операции с файлами"},
     *     summary="загрузка csv файла",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *                  type="object",
     *                  required={"file" },                 
     *                 @OA\Property(
     *                      property="file",
     *                      type="string",
     *                  ),
     *           )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="Упешная отправка",
     *         @OA\JsonContent(
     *                 type="object",
     *                 required={"success","result"},
     *                 @OA\Property(
     *                     property="success",
     *                     type="boolean",
     *                 ),
     *          ),
     *     )
     * )
     */
    public function uploadFile(UploadRequest $request)
    {
        $this->baseFileService->encodeFileCsv($request->file);
        return response()->json([
            'success' => true,
        ]);
    }

    

}