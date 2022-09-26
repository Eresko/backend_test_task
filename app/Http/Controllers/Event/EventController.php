<?php

namespace App\Http\Controllers\Event;

use App\Events\CloseOrder;
use App\Events\PartialPayment;
use App\Events\ChangeOrderPosition;
use App\Jobs\PartialPaymentJobs;
use Illuminate\Http\Request;


class EventController {

    /**
     * @OA\Post(
     *     path="/api/close-order",
     *     tags={"События"},
     *     summary="Событие закрытия заказа",
     *     @OA\RequestBody(description="Properties", required=true,
     *          @OA\JsonContent(
     *              type="object",
     *                 required={"session"},
     *                @OA\Property(
     *                     property="session",
     *                     description="session",
     *                     type="number",
     *                     example="1"
     *                 ),
     *          ),
     *     ),
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
    public function closeOrder(Request $request)
    {
        $validated = $request->validate([
            'session' => 'required|integer'
        ]);

        broadcast(new CloseOrder(intval($request->session)));
        return response()->json(
            ['success' => true]
        );
    }

    /**
     * @OA\Post(
     *     path="/api/partial-payment",
     *     tags={"События"},
     *     summary="Событие оплаты заказа",
     *     @OA\RequestBody(description="Properties", required=true,
     *          @OA\JsonContent(
     *              type="object",
     *                 required={"session"},
     *                @OA\Property(
     *                     property="session",
     *                     description="session",
     *                     type="number",
     *                     example="1"
     *                 ),
     *          ),
     *     ),
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
    public function partialPayment(Request $request)
    {

        $validated = $request->validate([
            'session' => 'required|integer'
        ]);
        
        broadcast(new PartialPayment(intval($request->session)));
        return response()->json(
            ['success' => true]
        );
    }


    /**
     * @OA\Post(
     *     path="/api/change-order-position",
     *     tags={"События"},
     *     summary="Событие изменения заказа",
     *     @OA\RequestBody(description="Properties", required=true,
     *          @OA\JsonContent(
     *              type="object",
     *                 required={"session","message","massive"},
     *                @OA\Property(
     *                     property="session",
     *                     description="session",
     *                     type="number",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     description="ok",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="massive",
     *                     description="massive",
     *                     type="string",
     *                     example="1"
     *                 ),
     *          ),
     *     ),
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
    public function changeOrderPosition(Request $request)
    {

        $validated = $request->validate([
            'session' => 'required|integer',
            'message' => 'required|string',
            'massive' => 'required|array'
        ]);
        file_put_contents(base_path() . '/storage/first.txt', print_r($validated, true), FILE_APPEND | LOCK_EX);
        foreach ($request->massive as $item) {
            broadcast(new ChangeOrderPosition(intval($request->session),$request->message,$item));
        }

        return response()->json(
            ['success' => true]
        );
    }






}