<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePartidaTimeAPIRequest;
use App\Http\Requests\API\UpdatePartidaTimeAPIRequest;
use App\Models\PartidaTime;
use App\Repositories\PartidaTimeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PartidaTimeController
 * @package App\Http\Controllers\API
 */

class PartidaTimeAPIController extends AppBaseController
{
    /** @var  PartidaTimeRepository */
    private $partidaTimeRepository;

    public function __construct(PartidaTimeRepository $partidaTimeRepo)
    {
        $this->partidaTimeRepository = $partidaTimeRepo;
    }

    /**
     * Display a listing of the PartidaTime.
     * GET|HEAD /partidaTimes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $partidaTimes = $this->partidaTimeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($partidaTimes->toArray(), 'Partida Times retrieved successfully');
    }

    /**
     * Store a newly created PartidaTime in storage.
     * POST /partidaTimes
     *
     * @param CreatePartidaTimeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePartidaTimeAPIRequest $request)
    {
        $input = $request->all();

        $partidaTime = $this->partidaTimeRepository->create($input);

        return $this->sendResponse($partidaTime->toArray(), 'Partida Time saved successfully');
    }

    /**
     * Display the specified PartidaTime.
     * GET|HEAD /partidaTimes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PartidaTime $partidaTime */
        $partidaTime = $this->partidaTimeRepository->find($id);

        if (empty($partidaTime)) {
            return $this->sendError('Partida Time not found');
        }

        return $this->sendResponse($partidaTime->toArray(), 'Partida Time retrieved successfully');
    }

    /**
     * Update the specified PartidaTime in storage.
     * PUT/PATCH /partidaTimes/{id}
     *
     * @param int $id
     * @param UpdatePartidaTimeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePartidaTimeAPIRequest $request)
    {
        $input = $request->all();

        /** @var PartidaTime $partidaTime */
        $partidaTime = $this->partidaTimeRepository->find($id);

        if (empty($partidaTime)) {
            return $this->sendError('Partida Time not found');
        }

        $partidaTime = $this->partidaTimeRepository->update($input, $id);

        return $this->sendResponse($partidaTime->toArray(), 'PartidaTime updated successfully');
    }

    /**
     * Remove the specified PartidaTime from storage.
     * DELETE /partidaTimes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PartidaTime $partidaTime */
        $partidaTime = $this->partidaTimeRepository->find($id);

        if (empty($partidaTime)) {
            return $this->sendError('Partida Time not found');
        }

        $partidaTime->delete();

        return $this->sendSuccess('Partida Time deleted successfully');
    }
}
