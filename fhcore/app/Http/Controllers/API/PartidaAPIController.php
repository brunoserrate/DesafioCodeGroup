<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePartidaAPIRequest;
use App\Http\Requests\API\UpdatePartidaAPIRequest;
use App\Models\Partida;
use App\Repositories\PartidaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PartidaController
 * @package App\Http\Controllers\API
 */

class PartidaAPIController extends AppBaseController
{
    /** @var  PartidaRepository */
    private $partidaRepository;

    public function __construct(PartidaRepository $partidaRepo)
    {
        $this->partidaRepository = $partidaRepo;
    }

    /**
     * Display a listing of the Partida.
     * GET|HEAD /partidas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $partidas = $this->partidaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($partidas->toArray(), 'Partidas retrieved successfully');
    }

    /**
     * Store a newly created Partida in storage.
     * POST /partidas
     *
     * @param CreatePartidaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePartidaAPIRequest $request)
    {
        $input = $request->all();

        $partida = $this->partidaRepository->create($input);

        return $this->sendResponse($partida->toArray(), 'Partida saved successfully');
    }

    /**
     * Display the specified Partida.
     * GET|HEAD /partidas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Partida $partida */
        $partida = $this->partidaRepository->find($id);

        if (empty($partida)) {
            return $this->sendError('Partida not found');
        }

        return $this->sendResponse($partida->toArray(), 'Partida retrieved successfully');
    }

    /**
     * Update the specified Partida in storage.
     * PUT/PATCH /partidas/{id}
     *
     * @param int $id
     * @param UpdatePartidaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePartidaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Partida $partida */
        $partida = $this->partidaRepository->find($id);

        if (empty($partida)) {
            return $this->sendError('Partida not found');
        }

        $partida = $this->partidaRepository->update($input, $id);

        return $this->sendResponse($partida->toArray(), 'Partida updated successfully');
    }

    /**
     * Remove the specified Partida from storage.
     * DELETE /partidas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Partida $partida */
        $partida = $this->partidaRepository->find($id);

        if (empty($partida)) {
            return $this->sendError('Partida not found');
        }

        $partida->delete();

        return $this->sendSuccess('Partida deleted successfully');
    }

    public function gerarTime(Request $request)
    {
        $input = $request->all();

        $partida = $this->partidaRepository->gerarTime($input);

        return $this->sendResponse($partida, 'Partida saved successfully');
    }
}
