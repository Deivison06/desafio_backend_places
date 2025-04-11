<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PlacesController extends Controller
{
    public function __construct(private PlaceService $placeService) {}

    /**
     * Display a listing of the places.
     */
    public function index(): JsonResponse
    {
        $places = $this->placeService->list(request('name'));
        return response()->json($places, Response::HTTP_OK);
    }

    /**
     * Store a newly created place in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $place = $this->placeService->create($request);
        return response()->json($place, Response::HTTP_CREATED);
    }

    /**
     * Display the specified place.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $place = $this->placeService->find($id);
            return response()->json($place, Response::HTTP_OK);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified place in storage.
     */
    public function update(Request $request, Place $place): JsonResponse
    {
        $updatedPlace = $this->placeService->update($place, $request->all());
        return response()->json($updatedPlace, Response::HTTP_OK);
    }

    /**
     * Remove the specified place from storage.
     */
    public function destroy(Place $place): JsonResponse
    {
        $this->placeService->delete($place);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
