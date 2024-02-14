<?php

namespace App\Http\Controllers\Products;

use stdClass;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Packages\ApiResponse\ApiResponseBuilder;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $table;
    protected $defaultPerPage = 10;
    protected $properties = [
        'name' => 'required|max:32|string',
        'description' => 'nullable|max:128|string',
        'price' => 'required|numeric'
    ];

    public function __construct()
    {
        $model = new Product();
        $this->table = $model->getTable();
    }

    private function createModel()
    {
        return new Product();
    }

    private function createResource(object $entity)
    {
        return new ProductResource($entity);
    }

    private function createResourceCollection(Collection $entities)
    {
        return ProductResource::collection($entities);
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $foundEntities = DB::table($this->table)
            ->whereNull('deleted_at')
            ->paginate($this->defaultPerPage);

        if (!$foundEntities) {
            $serviceResponse = response()->json(null, Response::HTTP_NOT_FOUND);
        } else {
            $response = new stdClass();
            $response->items = $this->createResourceCollection(
                collect($foundEntities->items())
            );
            $response->pagination = paginate($foundEntities);
            $serviceResponse = response()->json($response, Response::HTTP_OK);
        }

        return $this->buildResponse($serviceResponse, [
            'ok' => 'Producto creado correctamente',
            'fail' => 'Error al crear el producto'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $parameters = $request->only(array_keys($this->properties));
        $validator = Validator::make($parameters, $this->properties);
        if ($validator->fails()) {
            return ApiResponseBuilder::builder()
                ->withCode(Response::HTTP_BAD_REQUEST)
                ->withMessage("Error en validación de datos")
                ->withData($validator->errors())
                ->build();
        }

        $newEntity = $this->createModel();
        $newEntity->name = $parameters['name'];
        $newEntity->description = $parameters['description'];
        $newEntity->price = $parameters['price'];
        $isSaved = $newEntity->save();

        if (!$isSaved) {
            $serviceResponse = response()->json(null, Response::HTTP_BAD_REQUEST);
        } else {
            $response = new stdClass();
            $response->items = $this->createResource($newEntity);
            $serviceResponse = response()->json($response, Response::HTTP_OK);
        }

        return $this->buildResponse($serviceResponse, [
            'ok' => 'Producto creado correctamente',
            'fail' => 'Error al crear el producto'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function getById(int $id)
    {
        $entity = DB::table($this->table)
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$entity) {
            $serviceResponse = response()->json(null, Response::HTTP_NOT_FOUND);
        } else {
            $response = new stdClass();
            $response->items = $this->createResource($entity);
            $serviceResponse = response()->json($response, Response::HTTP_OK);
        }

        return $this->buildResponse($serviceResponse, [
            'ok' => 'Producto actualziado correctamente',
            'fail' => 'Error al actualizar el producto'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $parameters = $request->only(array_keys($this->properties));
        $validator = Validator::make($parameters, $this->properties);
        if ($validator->fails()) {
            return ApiResponseBuilder::builder()
                ->withCode(Response::HTTP_BAD_REQUEST)
                ->withMessage("Error en validación de datos")
                ->withData($validator->errors())
                ->build();
        }

        $entity = [
            'updated_at' => now(),
            'name' => $parameters['name'],
            'description' => $parameters['description'],
            'price' => $parameters['price']
        ];

        $isUpdated = DB::table($this->table)
            ->where('id', $id)
            ->update($entity);
        if (!$isUpdated) {
            $serviceResponse = response()->json(null, Response::HTTP_NOT_FOUND);
        } else {
            $response = new stdClass();
            $response->items = $this->createResource(arrayToObject($entity));
            $serviceResponse = response()->json($response, Response::HTTP_OK);
        }
        return $this->buildResponse($serviceResponse, [
            'ok' => 'Producto actualziado correctamente',
            'fail' => 'Error al actualizar el producto'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        $isDeleted = DB::table($this->table)
            ->where('id', $id)
            ->update([
                'deleted_at' => now()
            ]);

        if (!$isDeleted) {
            $serviceResponse = response()->json(null, Response::HTTP_NOT_FOUND);
        } else {
            $response = new stdClass();
            $response->items = $isDeleted;
            $serviceResponse = response()->json($response, Response::HTTP_OK);
        }

        return $this->buildResponse($serviceResponse, [
            'ok' => 'Producto eliminado correctamente',
            'fail' => 'Error al eliminar el producto'
        ]);
    }

    public function buildResponse($serviceResponse, $message)
    {
        $data = $serviceResponse->getData();

        if ($serviceResponse->getStatusCode() != Response::HTTP_OK) {
            return ApiResponseBuilder::builder()
                ->withCode($serviceResponse->getStatusCode())
                ->withMessage($message['fail'])
                ->withData($data)
                ->build();
        }

        return ApiResponseBuilder::builder()
            ->withCode($serviceResponse->getStatusCode())
            ->withMessage($message['ok'])
            ->withData($data->items)
            ->build();
    }
}
