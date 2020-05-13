<?php
/**
 * User controller
 *
 * Controller that handles creating, updating, fetching, and deleting users in the system
 *
 * @author Justin Pohlmann
 */

namespace App\Http\Controllers;

use \App\Http\Controllers\Controller;
use \Laravel\Lumen\Http\Request;
use App\Http\Models\User;
use \Illuminate\Http\JsonResponse;
use \Laravel\Lumen\Http\ResponseFactory;

class UserController extends Controller
{
    /**
     * Get all users in the system
     *
     * @return JsonResponse
     */
    public function fetchAll() : JsonResponse
    {
        $user = new User();
        return response()->json(User::all());
    }

    /**
     * Fetch a single user by their id
     *
     * @param int $id Id of user
     *
     * @return JsonResponse
     */
    public function fetchOne(int $id) : JsonResponse
    {
        return response()->json(User::find($id));
    }

    /**
     * Create a new user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $this->validate(request(), [
            'name' => 'required|unique:users'
        ]);
        $user = User::create(request()->all());
        return response()->json($user, 201);
    }

    /**
     * Update an existing user
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request) : JsonResponse
    {
        $this->validate(request(), [
            'name' => 'required|unique:users'
        ]);
        $user = User::findOrFail($id);
        $user->update(request()->all());

        return response()->json($user, 200);

    }
    public function delete(int $id) : ResponseFactory
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);

    }
}