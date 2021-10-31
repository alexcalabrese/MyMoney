<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransactionResource::collection(Transaction::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'total'         => 'required',
            'date'          => 'required',
            'type'          => 'required',
            'category_id'   => 'required',
            'state_id'      => 'required',
            'timing_id'     => 'required',
            'method_id'     => 'required',
        ]);


        $total = $request->total;
        $notes = $request->notes;
        $date = $request->date;
        $type = $request->type;
        $category_id = $request->category_id;
        $state_id = $request->state_id;
        $timing_id = $request->timing_id;
        $method_id = $request->method_id;

        $transaction = Transaction::create([
            'total' => $total,
            'notes' => $notes,
            'date' => date("Y-m-d", strtotime($date)),
            'type' => $type,
            'category_id' => $category_id,
            'state_id' => $state_id,
            'timing_id' => $timing_id,
            'method_id' => $method_id,
            'created_at' => now(),
        ]);


        return response(200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function totalCosts()
    {
        return Transaction::where('type', '-')->sum('total');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function totalEarnings()
    {
        return Transaction::where('type', '+')->sum('total');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function totalBalance()
    {
        $costs = $this->totalCosts();
        $earnings = $this->totalEarnings();

        return $earnings - $costs;
    }
}
