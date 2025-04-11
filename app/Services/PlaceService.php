<?php

namespace App\Services;

use App\Models\Place;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PlaceService
{
    /**
     * List places with optional filtering.
     */
    public function list(?string $filter = null): LengthAwarePaginator
    {
        return Place::when($filter, function ($query, $filter) {
            return $query->where('name', 'ILIKE', "%{$filter}%");
        })->paginate(10);
    }

    /**
     * Find a place by its ID.
     */
    public function find(int $id): Place
    {
        return Place::findOrFail($id);
    }

    /**
     * Create a new place.
     */
    public function create(Request $request): Place
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $validated['slug'] = Str::slug($validated['name']);

        return Place::create($validated);
    }


    /**
     * Update an existing place.
     */
    public function update(Place $place, array $data): Place
    {
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $place->update($validated);
        return $place->fresh();
    }

    /**
     * Delete a place.
     */
    public function delete(Place $place): void
    {
        $place->delete();
    }
}
