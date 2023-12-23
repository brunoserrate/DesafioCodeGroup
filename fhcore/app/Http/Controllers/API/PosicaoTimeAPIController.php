<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePosicaoTimeAPIRequest;
use App\Http\Requests\API\UpdatePosicaoTimeAPIRequest;
use App\Models\PosicaoTime;
use App\Repositories\PosicaoTimeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PosicaoTimeController
 * @package App\Http\Controllers\API
 */

class PosicaoTimeAPIController extends AppBaseController
{
    /** @var  PosicaoTimeRepository */
    private $posicaoTimeRepository;

    public function __construct(PosicaoTimeRepository $posicaoTimeRepo)
    {
        $this->posicaoTimeRepository = $posicaoTimeRepo;
    }

    /**
     * Display a listing of the PosicaoTime.
     * GET|HEAD /posicaoTimes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $posicaoTimes = $this->posicaoTimeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($posicaoTimes->toArray(), 'Posicao Times retrieved successfully');
    }

    /**
     * Store a newly created PosicaoTime in storage.
     * POST /posicaoTimes
     *
     * @param CreatePosicaoTimeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePosicaoTimeAPIRequest $request)
    {
        $input = $request->all();

        $posicaoTime = $this->posicaoTimeRepository->create($input);

        return $this->sendResponse($posicaoTime->toArray(), 'Posicao Time saved successfully');
    }

    /**
     * Display the specified PosicaoTime.
     * GET|HEAD /posicaoTimes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PosicaoTime $posicaoTime */
        $posicaoTime = $this->posicaoTimeRepository->find($id);

        if (empty($posicaoTime)) {
            return $this->sendError('Posicao Time not found');
        }

        return $this->sendResponse($posicaoTime->toArray(), 'Posicao Time retrieved successfully');
    }

    /**
     * Update the specified PosicaoTime in storage.
     * PUT/PATCH /posicaoTimes/{id}
     *
     * @param int $id
     * @param UpdatePosicaoTimeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePosicaoTimeAPIRequest $request)
    {
        $input = $request->all();

        /** @var PosicaoTime $posicaoTime */
        $posicaoTime = $this->posicaoTimeRepository->find($id);

        if (empty($posicaoTime)) {
            return $this->sendError('Posicao Time not found');
        }

        $posicaoTime = $this->posicaoTimeRepository->update($input, $id);

        return $this->sendResponse($posicaoTime->toArray(), 'PosicaoTime updated successfully');
    }

    /**
     * Remove the specified PosicaoTime from storage.
     * DELETE /posicaoTimes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PosicaoTime $posicaoTime */
        $posicaoTime = $this->posicaoTimeRepository->find($id);

        if (empty($posicaoTime)) {
            return $this->sendError('Posicao Time not found');
        }

        $posicaoTime->delete();

        return $this->sendSuccess('Posicao Time deleted successfully');
    }
}
