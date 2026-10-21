<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // 1. Tambahkan validasi untuk input gambar
    $data = $request->validate([
        'name' => 'required',
        'sku' => 'required|unique:products,sku',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
    ]);

    $file = $request->file('image');

    // 3. Proses gambar jika ada file yang diunggah
    if ($file) {
        $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '', $original) . '.' . $ext;
        $folder = 'products';
        $path = $folder . '/' . $filename;

        // Inisialisasi ImageManager dengan GD Driver dan crop/resize
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($file->getRealPath())->cover(800, 800);

        // Encode gambar sesuai ekstensi
        if ($ext === 'png') {
            $encoded = $image->toPng();
        } elseif ($ext === 'webp') {
            $encoded = $image->toWebp(85);
        } else {
            $encoded = $image->toJpeg(85);
        }

        // Simpan ke folder storage/app/public/products
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $encoded->toString());
        
        // Tambahkan path gambar ke data yang akan disimpan ke database
        $data['image'] = $path;
    }

    // 4. Simpan ke database menggunakan array $data
    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $id,
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}