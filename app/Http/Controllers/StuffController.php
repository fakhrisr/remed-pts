<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Stuff;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    public function index()
    {
        try {
            // Ambil data yang ingin ditampilkan
            $data = Stuff::all()->toArray();

            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
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
        try {
            // validasi
            $this->validate($request, [
                'name' => 'required',
                'category' => 'required',
            ]);
    
            // proses tambah data
            $data = Stuff::create([
                'name' => $request->name,
                'category' => $request->category,
            ]);
    
            return ApiFormatter::sendResponse(200, 'success', $data);
    
        } catch (Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $getStuff= stuff::where('id', $id)->with('stuffstock', 'inboundstuff', 'lendings')->first();
    
            if (!$getStuff) {
                return ResponseFormatter::sendResponse(400, 'bad request', 'Data not found!');
            } else {
                return ResponseFormatter::sendResponse(200, 'success', $data);
            }
    
        } catch (Exception $err) {
            return ResponseFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function edit(stuff $stuff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'category' => 'required'
            ]);
    
            $checkProses = Stuff::where('id', $id)->update([
                'name' => $request->name,
                'category' => $request->category
            ]);
    
            if ($checkProses) {
                $data = Stuff::find($id);
                return ApiFormatter::sendResponse(200, 'success', $data);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'Gagal mengubah data!');
            }
    
        } catch (Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\stuff  $stuff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    try {
        $checkProses = Stuff::where('id', $id)->delete();
        
        return ApiFormatter::sendResponse(200, 'success', 'Data stuff berhasil dihapus!');

    } catch (Exception $err) {
        return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
    }
}
    public function trash()
{
    try {
        // onlyTrashed: mencari data yang deleted_at tidak null
        $data = Stuff::onlyTrashed()->get();
        
        return ApiFormatter::sendResponse(200, 'success', $data);
    } catch (Exception $err) {
        return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
    }
}
    public function restore($id)
{
    try {
        $checkProses = Stuff::onlyTrashed()->where('id', $id)->restore();
        
        if ($checkProses) {
            $data = Stuff::find($id);
            return ApiFormatter::sendResponse(200, 'success', $data);
        } else {
            return ApiFormatter::sendResponse(400, 'bad request', 'Gagal mengembalikan data!');
        }
    } catch (Exception $err) {
        return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
    }
}

    public function deletePermanent($id)
{
    try {
        $checkProses = Stuff::onlyTrashed()->where('id', $id)->forceDelete();
        
        return ApiFormatter::sendResponse(200, 'success', 'Berhasil menghapus permanen data stuff!');
    } catch (Exception $err) {
        return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
    }
}

public function __construct()
{
$this->middleware('auth:api');
}


}

