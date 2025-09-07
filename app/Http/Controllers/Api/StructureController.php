<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StructureResource;
use App\Http\Requests\StructureStoreRequest;
use App\Http\Requests\StructureUpdateRequest;
use App\Models\Structure;
use Illuminate\Http\JsonResponse;

class StructureController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/structures",
 *     summary="List all structures with pagination",
 *     tags={"Structures"},
 *     @OA\Response(
 *         response=200,
 *         description="List of structures",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Structure")
 *         )
 *     ),
 *     security={{"sanctum":{}}}
 * )
 */
    public function index(): JsonResponse
    {
        $structures = Structure::with('services')->get();
        return response()->json(StructureResource::collection($structures));
    }

    /**
 * @OA\Post(
 *     path="/api/v1/structures",
 *     summary="Create a new structure",
 *     tags={"Structures"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom", "code"},
 *            @OA\Property(property="nom", type="string", example="Structure Name"),
 *           @OA\Property(property="code", type="string", example="STRUCT001")
 *        )
 *   ),
 *    @OA\Response(
 *        response=201,
 *       description="Structure created successfully",
 *      @OA\JsonContent(ref="#/components/schemas/Structure")
 *   ),
 *   security={{"sanctum":{}}}
 *
 * )
 */
    /**
     * Store a newly created structure in storage.
     *
     * @param StructureStoreRequest $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/api/v1/structures",
     *     summary="Create a new structure",
     *     tags={"Structures"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom", "code"},
     *             @OA\Property(property="nom", type="string", example="Structure Name"),
     *             @OA\Property(property="code", type="string", example="STRUCT001")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Structure created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Structure")
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function store(StructureStoreRequest $request): JsonResponse
    {
        $structure = Structure::create($request->validated());
        return response()->json(new StructureResource($structure), 201);
    }

    public function show(Structure $structure): JsonResponse
    {
        $structure->load('services');
        return response()->json(new StructureResource($structure));
    }

    public function update(StructureUpdateRequest $request, Structure $structure): JsonResponse
    {
        $structure->update($request->validated());
        return response()->json(new StructureResource($structure));
    }

    public function destroy(Structure $structure): JsonResponse
    {
        $structure->delete();
        return response()->json(null, 204);
    }
}
