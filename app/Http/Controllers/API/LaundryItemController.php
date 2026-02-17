<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LaundryItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LaundryItemController extends Controller
{
    public function index()
    {
        $items = LaundryItem::with(['category', 'status', 'user'])->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $item = LaundryItem::create($validated);
        return response()->json($item, Response::HTTP_CREATED);
    }

    public function show(LaundryItem $laundryItem)
    {
        return response()->json($laundryItem->load(['category', 'status', 'user']));
    }

    public function update(Request $request, LaundryItem $laundryItem)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:70',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'status_id' => 'sometimes|exists:statuses,id',
        ]);

        $laundryItem->update($validated);
        return response()->json($laundryItem);
    }

    public function destroy(LaundryItem $laundryItem)
    {
        $laundryItem->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
