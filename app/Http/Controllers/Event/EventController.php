<?php

namespace App\Http\Controllers\Event;

use App\Events\CloseOrder;
use App\Events\PartialPayment;
use App\Events\ChangeOrderPosition;
use App\Events\SetDiscount;
use App\Events\DiscountNotAppliedEvents;
use App\Events\WaitingDiscount;
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
            'massive' => 'sometimes|array'
        ]);

        foreach ($request->massive as $item) {
            broadcast(new ChangeOrderPosition(intval($request->session),$request->message,$item));
        }
        if ((empty($request->massive)) && ($request->message== 'update order')){
            
            broadcast(new ChangeOrderPosition(intval($request->session),$request->message,[]));

        }

        return response()->json(
            ['success' => true]
        );
    }


    /**
     * @OA\Post(
     *     path="/api/set-discount",
     *     tags={"События"},
     *     summary="Событие применение скидки",
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
    public function setDiscount(Request $request)
    {

        $validated = $request->validate([
            'session' => 'required|integer'
        ]);
        broadcast(new SetDiscount(intval($request->session)));
        return response()->json(
            ['success' => true]
        );
    }
    /**
     * @OA\Post(
     *     path="/api/waiting-discount",
     *     tags={"События"},
     *     summary="Событие ожидание применения скидки",
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
    public function waitingDiscount(Request $request)
    {

        $validated = $request->validate([
            'session' => 'required|integer'
        ]);
        broadcast(new WaitingDiscount(intval($request->session)));
        return response()->json(
            ['success' => true]
        );
    }

    /**
     * @OA\Post(
     *     path="/api/discount-not-applied",
     *     tags={"События"},
     *     summary="Событие ожидание применения скидки",
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
    public function discountNotApplied(Request $request)
    {

        $validated = $request->validate([
            'session' => 'required|integer'
        ]);
        broadcast(new DiscountNotAppliedEvents(intval($request->session)));
        return response()->json(
            ['success' => true]
        );
    }



}