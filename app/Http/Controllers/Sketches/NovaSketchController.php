<?php

namespace App\Http\Controllers\Sketches;

use App\Http\Controllers\SketchController;
use Illuminate\Http\JsonResponse;

/**
 * Laravel Nova methods.
 *
 * @order 20
 */
class NovaSketchController extends SketchController
{
    /**
     * Gets all Nova resources.
     */
    public function getAllNovaResourcesCollection(): JsonResponse
    {
        return $this->json(getAllNovaResourcesCollection());
    }

    /**
     * Gets all Nova resource models.
     */
    public function getNovaModelsCollection(): JsonResponse
    {
        return $this->json(getNovaModelsCollection());
    }

    /**
     * Gets all Nova resource models.
     */
    public function getAllNovaResourceTables(): JsonResponse
    {
        return $this->json(getAllNovaResourceTables());
    }
}
