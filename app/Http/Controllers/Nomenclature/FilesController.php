<?php

namespace App\Http\Controllers\Nomenclature;


use Illuminate\Http\Request;
use App\Services\BaseFIleService;
use App\Services\FilesService;


class FilesController {

    public function __construct(
        private FilesService $filesService
    ) {
    }



    /**
     * @OA\Get(
     *     path="/api/nomenclature/list",
     *     tags={"Файлы"},
     *     summary="Список файлов",
     *     @OA\Parameter(
     *       name="page",
     *       in="query",
     *       @OA\Schema(
     *               type="integer"
     *           )
     *      ),
     *     @OA\Parameter(
     *        name="search",
     *        in="query",
     *        @OA\Schema(
     *                type="string"
     *            )
     *       ),
     *     @OA\Response(
     *           response="200",
     *           description="",
     *           @OA\JsonContent(
     *                   type="object",
     *                   required={"result"},
     *                   @OA\Property(
     *                       property="result",
     *                       type="object",
     *                       required={"currentPage","perPage","total","lastPage","data"},
     *                     @OA\Property(
     *                        property="currentPage",
     *                        type="integer",
     *                        description="Текущая страница",
     *                    ),
     *                    @OA\Property(
     *                         property="perPage",
     *                         type="integer",
     *                         description="Колличество элементов на странице",
     *                     ),
     *                    @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         description="Общее количество элементов",
     *                     ),
     *                    @OA\Property(
     *                         property="lastPage",
     *                         type="integer",
     *                         description="Последняя страница",
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Данные",
     *                       @OA\Items(
     *                        @OA\Property(property="id", type="integer", description="id элемента"),
     *                        @OA\Property(property="name", type="string",description="название файла" ),
     *                        @OA\Property(property="created_at", type="string", description="дата создания"),
     *                        @OA\Property(property="updated_at", type="string", description="дата изменения"),
     *                      )
     *                     ),
     *                   ),
     *            ),
     *       )
     * )
     */
    public function listFiles(Request $request)
    {

        return response()->json([
            'result' => $this->filesService->get(intval($request->page),$this->search)
        ]);
    }


    /**
     * @OA\Get(
     *     path="/api/nomenclature/get/{id}",
     *     tags={"Файлы"},
     *     summary="Содержимое файла",
     *     @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="",
     *          @OA\JsonContent(
     *                  type="object",
     *                  required={"result"},
     *                  @OA\Property(
     *                      property="result",
     *                      type="object",
     *                      required={"name","created_at","updated_at","file_element"},
     *                    @OA\Property(
     *                       property="name",
     *                       type="string",
     *                   ),
     *                   @OA\Property(
     *                        property="created_at",
     *                        type="number",
     *                    ),
     *                   @OA\Property(
     *                        property="updated_at",
     *                        type="number",
     *                    ),
     *                    @OA\Property(
     *                        property="file_element",
     *                        type="array",
     *                      @OA\Items(
     *                       @OA\Property(property="id", type="integer"),
     *                       @OA\Property(property="file_id", type="integer"),
     *                       @OA\Property(property="line", type="json"),
     *                       @OA\Property(property="created_at", type="string"),
     *                       @OA\Property(property="updated_at", type="string"),
     *                     )
     *                    ),
     *                  ),
     *           ),
     *      )
     * )
     */
    public function getFile(Request $request,$id)
    {

        return response()->json([
            'result' => $this->filesService->fileContents(intval($id))
        ]);
    }



}