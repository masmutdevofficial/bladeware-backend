<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductsAdmin extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = DB::table('products')->select('id', 'product_name', 'status', 'product_image', 'created_at');
    
    //     if ($request->has('search') && $request->search !== null) {
    //         $keyword = '%' . $request->search . '%';
    
    //         $query->where(function ($q) use ($request, $keyword) {
    //             if (is_numeric($request->search)) {
    //                 $q->orWhere('id', '=', $request->search);
    //             } else {
    //                 $q->orWhere('product_name', 'like', $keyword)
    //                   ->orWhere('status', 'like', $keyword);
    //             }
    //         });
    //     }
    
    //     $perPage = $request->input('per_page', 10); // default 10
    //     $products = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
    
    //     return view('admin.products', compact('products'));
    // }
    
    public function index()
    {
        // Mengambil semua data dari tabel products menggunakan Query Builder
        $products = DB::table('products')->get();

        // Kirim data ke view
        return view('admin.products', compact('products'));
    }
    
    public function addProducts(Request $request)
    {
        // Validasi input termasuk gambar
        $request->validate([
            'product_name' => 'required|string|max:255',
            'status' => 'required|integer',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Proses upload gambar jika ada
        $imageName = null;
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
        }
    
        // Simpan data produk ke database
        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'status' => $request->status,
            'product_image' => $imageName, // simpan nama file
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    // Update Produk
    public function editProducts(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'status' => 'required|integer',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $updateData = [
            'product_name' => $request->product_name,
            'status' => $request->status,
            'updated_at' => now(),
        ];
    
        // Cek jika ada gambar baru di-upload
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $updateData['product_image'] = $imageName;
    
            // Optional: Hapus file gambar lama (kalau mau)
            $oldImage = DB::table('products')->where('id', $id)->value('product_image');
            if ($oldImage && file_exists(public_path('uploads/products/' . $oldImage))) {
                unlink(public_path('uploads/products/' . $oldImage));
            }
        }
    
        DB::table('products')->where('id', $id)->update($updateData);
    
        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    // Hapus Produk
    public function deleteProducts($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        // Hapus produk dari database
        DB::table('products')->where('id', $id)->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }
}
