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
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {

        // Seleciona os quartos cadastrados ordenado pelo nome
        $query = Room::with('hotel')->orderBy('name');

        // Filtrar conforme a pesquisa caso enviado estes parametros:

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%'); //Filtra o nome do quarto
        }

        if ($request->filled('hotel')) {
            $query->whereHas('hotel', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->hotel . '%'); // Filtra o nome do Hotel do quarto
            });
        }

        $rooms = $query->get(); //Retorna os quartos que foram filtrados para a visualização

        return Inertia::render('Room/Index', [
            'rooms' => $rooms,
            'success' => session('success'),
            'filters' => $request->only(['name', 'hotel']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Recupera os hoteis cadastrados e envia para que seja possível vincular ao novo quarto que será cadastrado
        $hotels = Hotel::orderBy('name')->get();
        return Inertia::render('Room/Create', [
            'hotels' => $hotels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoomRequest $request)
    {
        // Valida os dados do formulário conforme o RoomRequest
        // Se algum campo estiver contra a validação do Request, retorna o feedback no errors do input que tiver com erro.
        // Se estiver tudo conforme os parâmetros, cria um novo registro com os dados enviados
        Room::create($request->validated());
        return redirect()->route('rooms.index')->with('success', 'Quarto cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Inertia\Response
     */
    public function show(string $id)
    {

        // Verifica se existe um quarto no banco com o id enviado e recupera seu registro.
        $room = Room::with('hotel')->findOrFail($id);

        // Recupera os hotéis cadastrados
        $hotels = Hotel::orderBy('name')->get();
        return Inertia::render('Room/Show', [
            'room' => $room,
            'hotels' => $hotels,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Inertia\Response
     */
    public function edit(string $id)
    {
        // Verifica se existe um quarto no banco com o id enviado e recupera seu registro.
        $room = Room::with('hotel')->findOrFail($id);
        // Recupera os hotéis cadastrados
        $hotels = Hotel::orderBy('name')->get();
        return Inertia::render('Room/Edit', [
            'room' => $room,
            'hotels' => $hotels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoomRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoomRequest $request, string $id)
    {
        // Valida os dados do formulário conforme o RoomRequest
        // Se algum campo estiver contra a validação do Request, retorna o feedback no errors do input que tiver com erro.

        // Verifica se existe um quarto no banco com o id enviado e recupera seu registro.
        $room = Room::findOrFail($id);

        // Se estiver tudo conforme os parâmetros do Request, atualiza o hotel encontrado com os dados enviados validados.
        $room->update($request->validated());
        return redirect()->route('rooms.index')->with('success', 'Quarto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {

        // Verifica se existe um quarto no banco com o id enviado e recupera seu registro.
        $room = Room::findOrFail($id);
        $room->delete(); // deleta este quarto do banco de dados
        return redirect()->route('rooms.index')->with('success', 'Quarto deletado com sucesso!');
    }
}
