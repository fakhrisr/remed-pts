<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use App\Models\StuffStock;
use App\Models\restoration;
use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;


class RestorationController extends Controller
{
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
         try{
             $this->validate($request, [
                 'user_id' => 'required',
                 'lending_id' => 'required',
                 'date_time' => 'required',
                 'total_good_stuff' => 'required',
                 'total_defec_stuff' => 'required',
             ]);
 
             $getLending = Lending::where('id', $request->lending_id)->first();//get data peminjam yg sesuia dngn pengembaliannya
 
             $totalStuff = $request->total_good_stuff + $request->total_defec_stuff;
             // variabel penampung jumlah barang yang akan dikembalikan
 
             if($getLending['total_stuff'] != $totalStuff) { //pengecekan apakah jumlah barang yg di pinjam jumlahnya sama atau tidak
                 return ApiFormatter::sendResponse(400, 'the amount of items returned does not match the amount borrowed');
             }else{
                 $getStuffStock = StuffStock::where('stuff_id', $getLending['stuff_id'])->first();//get data stuff stock yg barangnya sedang di pinjam
 
                 $createRestoration = Restoration::create([ // tambah data restoration
                     'user_id' => $request->user_id,
                     'lending_id' => $request->lending_id,
                     'date_time' => $request->date_time,
                     'total_good_stuff' => $request->total_good_stuff,
                     'total_defec_stuff' => $request->total_defec_stuff,
                 ]);
 
                 $updateStock = $getStuffStock->update([
                     'total_available' => $getStuffStock['total_available'] + $request->total_good_stuff,
                     'total_defec' => $getStuffStock['total_defec'] + $request->total_defec_stuff,
                 ]);// update jumlah barang yg tersedia yg di tambah dngn jumlah brnng bagus yg dikembalikan. dan update jumlah brng yg rusak ditambah dngn jmlh brng rusak yg dikembalikaln
 
                 if($createRestoration && $updateStock){
                     return ApiFormatter::sendResponse(200, 'successfully Create A Restoration Data', $createRestoration);
                 }
             }
         }catch(\Exception $e){
             return APiFormatter::sendResponse(400, $e->getMessage());
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

    public function __construct()
    {
    $this->middleware('auth:api');
    }
}
