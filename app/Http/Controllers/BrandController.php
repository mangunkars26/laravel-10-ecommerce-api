<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(10);

        return response()->json($brands, 200);
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return response()->json($brand, 200);
        } else return response()->json('Brand tak ditemukan');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brands,name',
            ]);

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->save();

            return response()->json("Brand telah ditambahkan", 201);
        } catch (\Exception $e) {
            return response()->json("$e", 500);
        }
    }

    public function update_brand($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $brand = Brand::where('id', $id)->update([
                'name' => $request->name
            ]);

            return response()->json('Brand diupdate', 200);
        } catch (\Exception $e) {
            return response()->json('$e', 500);
        }
    }

    public function delete_brand($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            return response()->json('Brand sukses dihapus');
        } else return response()->json('Brand tak ditemukan');
    }
}
