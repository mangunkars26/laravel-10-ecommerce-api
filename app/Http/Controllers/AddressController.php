<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create()
    {
        return view('address_form');
    }

    public function store(Request $request)
    {
        dd($request->all()); // Debugging purpose

        $request->validate([
            'alamat' => 'required|string|max:255',
            'kel' => 'required|string|max:100',
            'kec' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'prov' => 'required|string|max:100',
            'kodepos' => 'required|string|regex:/^\d{5}$/'
        ]);

        Address::create([
            'alamat'    =>  $request->alamat,
            'kel'       =>  $request->kel,
            'kec'       =>  $request->kec,
            'kota'      =>  $request->kota,
            'prov'      =>  $request->prov,
            'kodepos'   => $request->kodepos,
            'user_id'   => Auth::user()->id
        ]);

        return response()->json('Alamat telah ditambahkan', 201);
    }
}
