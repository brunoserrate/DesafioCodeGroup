<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTimeJogadorAPIRequest;
use App\Http\Requests\API\UpdateTimeJogadorAPIRequest;
use App\Models\TimeJogador;
use App\Repositories\TimeJogadorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TimeJogadorController
 * @package App\Http\Controllers\API
 */

class TimeJogadorAPIController extends AppBaseController
{
    /** @var  TimeJogadorRepository */
    private $timeJogadorRepository;

    public function __construct(TimeJogadorRepository $timeJogadorRepo)
    {
        $this->timeJogadorRepository = $timeJogadorRepo;
    }

    /**
     * Display a listing of the TimeJogador.
     * GET|HEAD /timeJogadors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $timeJogadors = $this->timeJogadorRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($timeJogadors->toArray(), 'Time Jogadors retrieved successfully');
    }

    /**
     * Store a newly created TimeJogador in storage.
     * POST /timeJogadors
     *
     * @param CreateTimeJogadorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTimeJogadorAPIRequest $request)
    {
        $input = $request->all();

        $timeJogador = $this->timeJogadorRepository->create($input);

        return $this->sendResponse($timeJogador->toArray(), 'Time Jogador saved successfully');
    }

    /**
     * Display the specified TimeJogador.
     * GET|HEAD /timeJogadors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TimeJogador $timeJogador */
        $timeJogador = $this->timeJogadorRepository->find($id);

        if (empty($timeJogador)) {
            return $this->sendError('Time Jogador not found');
        }

        return $this->sendResponse($timeJogador->toArray(), 'Time Jogador retrieved successfully');
    }

    /**
     * Update the specified TimeJogador in storage.
     * PUT/PATCH /timeJogadors/{id}
     *
     * @param int $id
     * @param UpdateTimeJogadorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTimeJogadorAPIRequest $request)
    {
        $input = $request->all();

        /** @var TimeJogador $timeJogador */
        $timeJogador = $this->timeJogadorRepository->find($id);

        if (empty($timeJogador)) {
            return $this->sendError('Time Jogador not found');
        }

        $timeJogador = $this->timeJogadorRepository->update($input, $id);

        return $this->sendResponse($timeJogador->toArray(), 'TimeJogador updated successfully');
    }

    /**
     * Remove the specified TimeJogador from storage.
     * DELETE /timeJogadors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TimeJogador $timeJogador */
        $timeJogador = $this->timeJogadorRepository->find($id);

        if (empty($timeJogador)) {
            return $this->sendError('Time Jogador not found');
        }

        $timeJogador->delete();

        return $this->sendSuccess('Time Jogador deleted successfully');
    }
}
