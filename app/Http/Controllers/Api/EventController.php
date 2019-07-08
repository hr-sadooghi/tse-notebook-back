<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Requests\ApiPostEvent;
use App\Http\Requests\ApiPostEventTrade;
use App\Link;
use App\Trade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenApi\Annotations AS OA;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EventController extends Controller
{
    /**
     * @OA\Post(path="/events", summary="add new event to company", tags={"event"},
     *     @OA\RequestBody(
     *          description="Post data to create a new trade and event resources.",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response( response="201", description="Success"),
     *     @OA\Response( response="422", description="Failed. Invalid parameters"),
     * )
     * @param ApiPostEvent $request
     * @return
     */
    public function post(ApiPostEvent $request)
    {
        $validated = $request->validated();

        $type = $request->get('type');
        $detail_id = $request->get('detail_id');
        $description = $request->get('description');
        $date = $request->get('date');
        $company_id = $request->get('company_id');
        //TODO: change it after JWT
        $user_id = auth()->id();

        $typeMaps = [
            'text' => null,
            'link' => 'App\\Link',
            'image' => 'App\\File',
            'file' => 'App\\File',
            'trade' => 'App\\Trade',
        ];

        $event = new Event();
        $event->user_id = $user_id;
        $event->company_id = $company_id;
        $event->description = $description;
        $event->type = $type;
        $event->date = $date;
        $event->detail_type = $typeMaps[$type];
        $event->detail_id = $detail_id;
        $event->save();
        return response([
            'message' => 'ثبت با موفقیت انجام شد.'
        ], 201);
    }

    /**
     * @OA\Put(path="/events/{eventId}", summary="update event", tags={"event"},
     *     @OA\Parameter(
     *          name="eventId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *          description="Put data to update event resource.",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response( response="201", description="Success"),
     *     @OA\Response( response="422", description="Failed. Invalid parameters"),
     * )
     * @param Request $request
     * @param Event $event
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function put(Request $request, Event $event)
    {
//        dump($request);
//        dd($event);
//        $validated = $request->validated();

        $description = $request->get('description');
//        dump($description);
        $date = $request->get('date');
        //TODO: change it after JWT
        $user_id = auth()->id();
        if($event->user_id !== $user_id){
            throw new BadRequestHttpException();
        }
        $event->description = $description;
        $event->date = $date;
        $event->save();
        return response([
            'message' => 'ثبت با موفقیت انجام شد.'
        ], 200);
    }

    /**
     * @OA\Post(tags="event", path="/events/trade", summary="add add new event to company", tags={"event"},
     *     @OA\RequestBody(
     *          description="Post data to create a new trade and event resources.",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EventTrade")
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Success",
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Failed. Invalid parameters",
     *     ),
     * )
     * @param ApiPostEventTrade $request
     * @return
     */
    public function postTrade(ApiPostEventTrade $request)
    {
        //"unit_price", "units", "type", "wage", "total_amount", "status", "description", "date", "company_id"
        $validated = $request->validated();

        $unit_price = $validated['unit_price'];//each unit price
        $units = $validated['units'];//number of units
        $type = $validated['type'];//sell | buy
        $wage = $validated['wage'];
        $total_amount = $validated['total_amount'];
        $status = $validated['status'];
        $description = $validated['description'];
        $date = $validated['date'];
        $company_id = $validated['company_id'];
        //TODO: change it after JWT
        $user_id = auth()->id();

        $trade = new Trade();
        $trade->unit_price = $unit_price;
        $trade->units = $units;
        $trade->type = $type;
        $trade->wage = $wage;
        $trade->total_amount = $total_amount;
        $trade->status = $status;
        $trade->save();

        $trade_id = $trade->id;

        $event = new Event();
        $event->user_id = $user_id;
        $event->company_id = $company_id;
        $event->description = $description;
        $event->type = 'trade';
        $event->date = $date;
        $event->detail_type = 'App\\Trade';
        $event->detail_id = $trade_id;
        $event->save();
        return response([
            'message' => 'ثبت با موفقیت انجام شد.',
            'data' => $validated
        ], 201);
    }

    public function postLink(Request $request)
    {
        $url = $request->get('url');
        $title = $request->get('title');
        $brief = $request->get('brief');
        $description = $request->get('description');
        $date = $request->get('date');
        $company_id = $request->get('company_id');
        //TODO: change it after JWT
        $user_id = auth()->id();

        $link = new Link();
        $link->url = $url;
        $link->title = $title;
        $link->brief = $brief;
        $link->save();

        $link_id = $link->id;

        $event = new Event();
        $event->user_id = $user_id;
        $event->company_id = $company_id;
        $event->description = $description;
        $event->type = 'link';
        $event->date = $date;
        $event->detail_type = 'App\\Link';
        $event->detail_id = $link_id;
        $event->save();
        return response([
            'message' => 'ثبت با موفقیت انجام شد.'
        ], 201);
    }

}
