<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ApiResponse
{
    /**
     * @param $message
     * @param  bool  $success
     * @param  int  $code
     * @param  null  $data
     * @return JsonResponse
     */
    protected function showMessage($message, $success = true, $code = 200, $data = null): JsonResponse
    {
        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'code'      => $code,
            'data'      => $data,
        ], $code);
    }

    /**
     * @param $data
     * @param  int  $code
     * @return JsonResponse
     */
    protected function successResponse($data, $code = 200): JsonResponse
    {
        return self::showMessage('Successfully', true, $code, $data);
    }

    /**
     * @param $message
     * @param $code
     * @param  null  $data
     * @return JsonResponse
     */
    protected function errorResponse($message, $code, $data = null): JsonResponse
    {
        return self::showMessage($message, false, $code, $data);
    }

    /**
     * @param  Collection  $collection
     * @param  int  $code
     * @return JsonResponse
     */
    protected function getAll(Collection $collection, $code = 200): JsonResponse
    {
        if ($collection->isEmpty()) {
            return self::errorResponse('Empty collection', $code = 401, null);
        }

        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);

        return response()->json($collection, $code);
    }

    /**
     * @param Model $model
     * @param int $code
     * @return JsonResponse
     */
    protected function getOne(Model $model, $code = 200): JsonResponse
    {
        return self::successResponse($model, $code);
    }

    /**
     * @param Collection $collection
     * @param $transformer
     * @return Collection|static
     */
    public function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);
            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    /**
     * @param Collection $collection
     * @param $transformer
     * @return Collection
     */
    protected function sortData(Collection $collection, $transformer): Collection
    {
        if (request()->has('sort_by')){
            $attribute = $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }

        return $collection;
    }

    /**
     * @param Collection $collection
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $collection): LengthAwarePaginator
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;

        if (request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return $paginated->appends(request()->all());
    }
}
