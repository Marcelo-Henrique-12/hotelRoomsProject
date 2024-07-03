<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Error;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Hotel::orderBy('name');
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        $hotels = $query->get();
        return Inertia::render('Hotel/Index', [
            'hotels' => $hotels,
            'success' => session('success'),
            'filters' => $request->only(['name','city','state']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Hotel/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request)
    {
        Hotel::create($request->validated());
        return redirect()->route('hotels.index')->with('success', 'Hotel cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $rooms = $hotel->rooms()->orderBy('name')->get();
        return Inertia::render('Hotel/Show', [
            'hotel' => $hotel,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        return Inertia::render('Hotel/Edit', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->validated());
        return redirect()->route('hotels.index')->with('success', 'Hotel atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deletado com sucesso!');
    }
}
