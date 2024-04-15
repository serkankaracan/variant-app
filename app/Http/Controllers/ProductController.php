<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Variant;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantValue;
use Illuminate\Http\Request;

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
        $categories = Category::all();
        $variants = Variant::all();
        //$variantValues = VariantValue::all();

        $variantValues = VariantValue::all()->groupBy('variant_id')->map(function ($values) {
            return $values->pluck('value')->toArray();
        });

        return view('products.create', compact('categories', 'variants', 'variantValues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Formdan gelen verileri doğrula
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'selected_combinations' => 'required|array',
            'stock' => 'required|array',
            'price' => 'required|array',
        ]);

        // Ürünü oluştur
        $product = Product::create([
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
            // Diğer alanları da eklemek isterseniz buraya ekleyebilirsiniz
        ]);

        // Kombinasyonları işle
        $combinations = $validatedData['selected_combinations'];
        $stocks = $validatedData['stock'];
        $prices = $validatedData['price'];

        foreach ($combinations as $index => $combinationIndex) {
            // Seçilen kombinasyonu al
            $combination = $request->input('variants')[$combinationIndex];
            // Her kombinasyon için stok ve fiyat bilgisini al
            $stock = $stocks[$index];
            $price = $prices[$index];

            // Ürünün ilişkili olduğu ProductVariant modeli üzerinden eklemek
            $product->variants()->create([
                'name' => $combination,
                'stock' => $stock,
                'price' => $price,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $product->id . '|max:255',
        ]);

        $product->update([
            'name' => $request->name,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
