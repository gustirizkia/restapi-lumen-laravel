<?php

namespace App\Http\Controllers;
use App\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $produk = Produk::all();

        return response()->json($produk);

    }

    public function show($id){
        $produk = Produk::find($id);
        return response()->json($produk);

    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'nama' => '|string',
            'harga' => 'integer',
            'warna' => '|string',
            'kondisi' => '|in:baru,bekas',
            'deskripsi' => 'string',
        ]);


        $produk = Produk::find($id);
        if(!$produk){
            return response()->json(['message' => 'Produk Not Found'], 404);
        }
        $data = $request->all();

        $produk->fill($data);
        $produk->save();

        return response()->json($produk);

    }
    public function destroy($id){
        $produk = Produk::find($id);
        if(!$produk){
            return response()->json(['message' => 'Produk Not Found'], 404);
        }
        $produk->delete();

        return response()->json(['message' => 'Produk Deleted!']);


    }

  public function create(Request $request){

    $this->validate($request, [
        'nama' => 'required|string',
        'harga' => 'integer|required',
        'warna' => 'required|string',
        'kondisi' => 'required|in:baru,bekas',
        'deskripsi' => 'string',
    ]);

    $data = $request->all();
    $produk = Produk::create($data);

    return response()->json($produk);

  }
}
