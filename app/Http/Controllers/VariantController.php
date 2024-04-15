<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use App\Models\VariantValue;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = Variant::all();
        return view('variants.index', compact('variants'));
        //return response()->json($variants);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('variants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'variant' => 'required|max:255',
            'variants.*' => 'required|max:255',
        ]);

        $newVariant = new Variant(['name' => $request->variant]);
        $newVariant->save();

        foreach ($request->variants as $variantName) {
            $variantValue = new VariantValue(['value' => $variantName]);
            $newVariant->values()->save($variantValue);
        }

        return redirect()->route('variants.index')->with('success', 'Variant and Values added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Variant $variant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant $variant)
    {
        $variantValues = VariantValue::where('variant_id', $variant->id)->get();
        return view('variants.edit', compact('variant', 'variantValues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variant $variant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'values.*' => 'required|string|max:255',
        ]);

        $variant->update([
            'name' => $request->name,
        ]);

        foreach ($request->values as $key => $value) {
            $variantValue = VariantValue::find($key);
            $variantValue->update([
                'value' => $value,
            ]);
        }

        return redirect()->route('variants.index')->with('success', 'Variant updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant)
    {
        $variant->delete();

        return redirect()->route('variants.index')->with('success', 'Variant deleted successfully.');
    }
}
