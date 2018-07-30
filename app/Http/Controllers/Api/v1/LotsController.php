<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\MarketException\LotDoesNotExistException;
use App\Request\AddLotRequest;
use App\Service\Contracts\MarketService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LotsController extends Controller
{

    private $marketService;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return response()->json([
                'error' => [
                    'message' => 'Only authorised users can add lots',
                    'code' => 403
                ]
            ], 403);
        }

        try{
//            dd($request->input('date_time_open'),$request->input('date_time_close'));
//            dd(strtotime($request->input('date_time_open')),strtotime($request->input('date_time_close')));
            $addLotRequest = new AddLotRequest(
                $request->input('currency_id'),
                Auth::id(),
                $request->input('date_time_open'),
                $request->input('date_time_close'),
                $request->input('price')
            );
//            print_r($addLotRequest);
            return response()->json($this->marketService->addLot($addLotRequest), 201);
        }
        catch (\LogicException $e)
        {
            dd($e);
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 400
                ]
            ], 400);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $lot = $this->marketService->getLot($id);
            return response()->json([
                'id' => $lot->getId(),
                'user_name' => $lot->getUserName(),
                'currency_name' => $lot->getCurrencyName(),
                'amount' => $lot->getAmount(),
                'date_time_open' => $lot->getDateTimeOpen(),
                'date_time_close' => $lot->getDateTimeClose(),
                'price' => $lot->getPrice()
            ]);
        } catch (LotDoesNotExistException $e) {
            dd($e);
            return response()->json([
                'error' => [
                    'message' => 'Lot does not exist',
                    'code' => 404
                ]
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
