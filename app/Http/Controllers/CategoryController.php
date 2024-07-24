<?php

namespace App\Http\Controllers;

use App\Models\Category;
// use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::paginate(10);

        return response()->json($category, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json($category, 200);
        } else return response()->json('Category tak ditemukan');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:category,name',
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return response()->json("Category telah ditambahkan", 201);
        } catch (\Exception $e) {
            return response()->json("$e", 500);
        }
    }

    public function update_category($id, Request $request)
    {
        try {
            // Validasi data yang masuk
            $validated = $request->validate([
                'name' => 'required',
                'image' => 'required|image' // Pastikan ini adalah gambar
            ]);

            // Cari kategori berdasarkan ID
            $category = Category::find($id);

            if (!$category) {
                return response()->json('Category not found', 404);
            }

            // Periksa apakah ada file gambar dalam request
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/category/' . $category->image;

                // Hapus gambar lama jika ada
                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $ext;

                try {
                    // Pindahkan gambar baru ke lokasi yang benar
                    $file->move('assets/uploads/category', $fileName);
                } catch (\Exception $e) {
                    return response()->json('Failed to upload image: ' . $e->getMessage(), 500);
                }

                // Perbarui gambar kategori
                $category->image = $fileName;
            }

            // Perbarui nama kategori
            $category->name = $request->name;
            $category->update();

            return response()->json('Category updated', 200);
        } catch (\Exception $e) {
            return response()->json('Error: ' . $e->getMessage(), 500);
        }
    }



    public function delete_category($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json('Category sukses dihapus');
        } else return response()->json('Category tak ditemukan');
    }
}
