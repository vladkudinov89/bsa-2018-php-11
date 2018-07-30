<?php

namespace App\Http\Controllers\Api\v1;

use App\Request\BuyLotRequest;
use App\Service\Contracts\MarketService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
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
        try {
//            dd($request->input('lot_id'));
            $buyLotRequest = new BuyLotRequest(
                Auth::id(),
                (int)$request->input('lot_id'),
                (float)$request->input('amount')
            );
            return response()->json($this->marketService->buyLot($buyLotRequest), 201);
        } catch (\LogicException $e) {
            return response()->json([
                dd($e->getMessage()),
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
        //
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
