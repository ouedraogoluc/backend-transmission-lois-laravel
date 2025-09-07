<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Structure;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::with('structure')->paginate(10);
        return response()->json(ServiceResource::collection($services));
    }

    public function store(ServiceStoreRequest $request): JsonResponse
    {
        // Trouver la structure à partir de l'ID dans la requête
        $structure = Structure::findOrFail($request->structure_id);

        $service = $structure->services()->create($request->validated());
        $service->load('structure');
        return response()->json(new ServiceResource($service), 201);
    }

    public function show(Service $service): JsonResponse
    {
        $service->load('structure');
        return response()->json(new ServiceResource($service));
    }

    public function update(ServiceUpdateRequest $request, Service $service): JsonResponse
    {
        $service->update($request->validated());
        $service->load('structure');
        return response()->json(new ServiceResource($service));
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->delete();
        return response()->json(null, 204);
    }

    public function getByStructure(Request $request, $structureId) {
    $perPage = $request->query('per_page', 10);
    $services = Service::where('structure_id', $structureId)->paginate($perPage);
    return response()->json([
      'data' => $services->items(),
      'meta' => [
        'total' => $services->total(),
        'current_page' => $services->currentPage(),
        'last_page' => $services->lastPage(),
        'per_page' => $services->perPage(),
      ],
    ]);
  }
}
