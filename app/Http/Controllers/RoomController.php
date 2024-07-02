<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('hotel')->orderBy('name')->get();
        return Inertia::render('Room/Index', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hotels = Hotel::orderBy('name')->get();
        return Inertia::render('Room/Create',[
            'hotels' => $hotels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {

        Room::create($request->validated());
        return redirect()->route('rooms.index')->with('success', 'Quarto cadastrado com sucesso!');
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
        $room = Room::with('hotel')->findOrFail($id);
        $hotels = Hotel::orderBy('name')->get();
        return Inertia::render('Room/Edit', [
            'room' => $room,
            'hotels' => $hotels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, string $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->validated());
        return redirect()->route('rooms.index')->with('success', 'Quarto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Quarto deletado com sucesso!');
    }
}
