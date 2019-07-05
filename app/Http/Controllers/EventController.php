<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\ApiPostEvent;
use App\Http\Requests\ApiPostEventTrade;
use App\Link;
use App\Trade;
use Illuminate\Http\Request;
use OpenApi\Annotations AS OA;

class EventController extends Controller
{
    /**
     * @OA\Post(
     *     path="/events/trade",
     *     summary="add add new event to company",
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
    public function apiPostTrade(ApiPostEventTrade $request)
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
        $user_id = 1;//auth()->id();

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

    /**
     * @OA\Post(path="/events", summary="add new event to company",
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
    public function apiPost(ApiPostEvent $request)
    {
        $validated = $request->validated();
        return $validated;
        $type = $request->get('type');
        $detail_id = $request->get('detail_id');
        $description = $request->get('description');
        $date = $request->get('date');
        $company_id = $request->get('company_id');
        $user_id = 1;//auth()->id();

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

    public function apiPostLink(Request $request)
    {
        $url = $request->get('url');
        $title = $request->get('title');
        $brief = $request->get('brief');
        $description = $request->get('description');
        $date = $request->get('date');
        $company_id = $request->get('company_id');
        $user_id = 1;//auth()->id();

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
