<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJogadorAPIRequest;
use App\Http\Requests\API\UpdateJogadorAPIRequest;
use App\Models\Jogador;
use App\Repositories\JogadorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class JogadorController
 * @package App\Http\Controllers\API
 */

class JogadorAPIController extends AppBaseController
{
    /** @var  JogadorRepository */
    private $jogadorRepository;

    public function __construct(JogadorRepository $jogadorRepo)
    {
        $this->jogadorRepository = $jogadorRepo;
    }

    /**
     * Display a listing of the Jogador.
     * GET|HEAD /jogadors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $jogadors = $this->jogadorRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($jogadors->toArray(), 'Jogadors retrieved successfully');
    }

    /**
     * Store a newly created Jogador in storage.
     * POST /jogadors
     *
     * @param CreateJogadorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateJogadorAPIRequest $request)
    {
        $input = $request->all();

        $jogador = $this->jogadorRepository->create($input);

        return $this->sendResponse($jogador->toArray(), 'Jogador saved successfully');
    }

    /**
     * Display the specified Jogador.
     * GET|HEAD /jogadors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Jogador $jogador */
        $jogador = $this->jogadorRepository->find($id);

        if (empty($jogador)) {
            return $this->sendError('Jogador not found');
        }

        return $this->sendResponse($jogador->toArray(), 'Jogador retrieved successfully');
    }

    /**
     * Update the specified Jogador in storage.
     * PUT/PATCH /jogadors/{id}
     *
     * @param int $id
     * @param UpdateJogadorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJogadorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Jogador $jogador */
        $jogador = $this->jogadorRepository->find($id);

        if (empty($jogador)) {
            return $this->sendError('Jogador not found');
        }

        $jogador = $this->jogadorRepository->update($input, $id);

        return $this->sendResponse($jogador->toArray(), 'Jogador updated successfully');
    }

    /**
     * Remove the specified Jogador from storage.
     * DELETE /jogadors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Jogador $jogador */
        $jogador = $this->jogadorRepository->find($id);

        if (empty($jogador)) {
            return $this->sendError('Jogador not found');
        }

        $jogador->delete();

        return $this->sendSuccess('Jogador deleted successfully');
    }
}
