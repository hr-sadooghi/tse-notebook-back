<?php

namespace App\Http\Controllers;

use App\Event;
use App\Link;
use App\Trade;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function apiPostTrade(Request $request)
    {
        $unit_price = $request->get('unit_price');//each unit price
        $units = $request->get('units');//number of units
        $type = $request->get('type');//sell | buy
        $wage = $request->get('wage');
        $total_amount = $request->get('total_amount');
        $status = $request->get('status');
        $description = $request->get('description');
        $date = $request->get('date');
        $company_id = $request->get('company_id');
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
            'message' => 'ثبت با موفقیت انجام شد.'
        ], 201);
    }

    public function apiPost(Request $request)
    {
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
