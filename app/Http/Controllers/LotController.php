<?php

namespace App\Http\Controllers;


use App\Request\AddLotFormRequest;
use App\Request\AddLotRequest;
use App\Service\MarketService;
use Illuminate\Support\Facades\Session;

class LotController extends Controller
{
    private $marketService;
    /**
     * LotController constructor.
     *
     * @param MarketService $marketService
     */
    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }
    public function add()
    {
        return view('add_lot');
    }
    public function store(AddLotFormRequest $request)
    {
        $addLotRequest = new AddLotRequest(
            $request->input('currency_id'),
            $request->input('seller_id'),
            $request->input('date_time_open'),
            $request->input('date_time_close'),
            $request->input('price')
        );
        try {
            $this->marketService->addLot($addLotRequest);
            Session::flash('message', 'Lot has been added successfully!');
        } catch (\Exception $e) {
            Session::flash('message', 'Sorry, error has been occurred: ' . $e->getMessage());
        }
        return redirect(route('lot.add'));
    }
}