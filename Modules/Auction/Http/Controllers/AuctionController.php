<?php

namespace Modules\Auction\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Http\Resources\AuctionResource;

class AuctionController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auctions = Auction::paginate(number_in_page());
        return AuctionResource::collection($auctions)->additional(['status' => 200, 'message' => 'Auctions fetched successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auction = Auction::findOrFail($id);
        return response()->json(new AuctionResource($auction), 200);
    }
}
