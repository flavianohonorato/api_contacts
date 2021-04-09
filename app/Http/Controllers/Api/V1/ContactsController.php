<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Support\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->getAll(Contact::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactRequest  $request
     * @return JsonResponse
     */
    public function store(ContactRequest $request): JsonResponse
    {
        try {
            $contact = Contact::create($request->all());
            return $this->getOne($contact);
        } catch (ModelNotFoundException | Exception $exception) {
            return response()->json([$exception->getMessage(), $exception->getCode()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $contact = Contact::findOrFail($id);
            return $this->getOne($contact, 201);
        } catch (ModelNotFoundException | Exception $exception) {
            return response()->json([$exception->getMessage(), $exception->getCode()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->update($request->all());

            return $this->getOne($contact);
        } catch (ModelNotFoundException | Exception $exception) {
            return response()->json([$exception->getMessage(), $exception->getCode()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $success = Contact::findOrFail($id)->delete();
            if ($success)
                return self::showMessage('Successfuly', true, 401);
        } catch (ModelNotFoundException | Exception $exception) {
            return response()->json([$exception->getMessage(), $exception->getCode()]);
        }
    }
}
