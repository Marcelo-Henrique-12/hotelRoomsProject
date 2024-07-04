<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HotelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */

    public function index(Request $request)
    {

        // Seleciona os Hotéis cadastrados ordenado pelo nome
        $query = Hotel::orderBy('name');

        // Filtrar conforme a pesquisa caso enviado estes parametros:

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%'); //Filtra o Nome do hotel
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%'); //Filtra a cidade do Hotel
        }
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%'); //Filtra o estado do Hotel
        }


        $hotels = $query->get(); //Retorna os hoteis que foram filtrados para a visualização

        //Renderiza o front-end
        return Inertia::render('Hotel/Index', [
            'hotels' => $hotels,
            'success' => session('success'),
            'filters' => $request->only(['name', 'city', 'state']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Renderiza o front-end com o formulário de criação de um novo hotel
        return Inertia::render('Hotel/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HotelRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function store(HotelRequest $request)
    {
        // Valida os dados do formulário conforme o HotelRequest
        // Se algum campo estiver contra a validação do Request, retorna o feedback no errors do input que tiver com erro.
        // Se estiver tudo conforme os parâmetros, cria um novo registro com os dados enviados
        Hotel::create($request->validated());

        // retorna para a pagina inicial de hoteis, com a mensagem de sucesso do cadastro
        return redirect()->route('hotels.index')->with('success', 'Hotel cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Inertia\Response
     */
    public function show(string $id)
    {


        // Verifica se existe um hotel no banco com o id enviado e recupera seu registro.
        $hotel = Hotel::findOrFail($id);

        // Recupera os quartos vinculados à este hotel registrado
        $rooms = $hotel->rooms()->orderBy('name')->get();

        // Renderiza o front para visualização detalhada do Hotel, com os seus quartos que estão vinculados.
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
        // Verifica se existe um hotel no banco com o id enviado e recupera seu registro.
        $hotel = Hotel::findOrFail($id);

        // Renderiza o front-end de edição para este hotel
        return Inertia::render('Hotel/Edit', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, string $id)
    {

        // Valida os dados do formulário conforme o HotelRequest
        // Se algum campo estiver contra a validação do Request, retorna o feedback no errors do input que tiver com erro.

        // Verifica se existe um hotel no banco com o id enviado e recupera seu registro.
        $hotel = Hotel::findOrFail($id);

        // Se estiver tudo conforme os parâmetros do Request, atualiza o hotel encontrado com os dados enviados validados.
        $hotel->update($request->validated());
        return redirect()->route('hotels.index')->with('success', 'Hotel atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(string $id)
    {
        // Verifica se existe um hotel no banco com o id enviado e recupera seu registro.
        $hotel = Hotel::findOrFail($id);
        $hotel->delete(); //Deleta este registro do banco de dados, e seus quartos vinculados em cascate

        return redirect()->route('hotels.index')->with('success', 'Hotel deletado com sucesso!');
    }
}
