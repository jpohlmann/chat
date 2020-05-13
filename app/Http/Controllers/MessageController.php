<?php
/**
 * Message controller
 *
 * Controller that handles creating, updating, fetching, and deleting messages in the system
 *
 * @author Justin Pohlmann
 */

namespace App\Http\Controllers;

use \App\Http\Controllers\Controller;
use \Laravel\Lumen\Http\Request;
use App\Http\Models\Message;
use \Illuminate\Http\JsonResponse;
use \Laravel\Lumen\Http\ResponseFactory;

class MessageController extends Controller
{
    /**
     * Get all messages in the system
     *
     * @return JsonResponse
     */
    public function fetchAll() : JsonResponse
    {
        $this->validate(request(),
            [
                'limit'        => 'integer|max:300',
                'recipient_id' => 'integer'
            ]
        );
        $message = new Message();
        $params  = request()->all();
        return response()->json($message->filter($params));
    }

    /**
     * Fetch a single message by their id
     *
     * @param int $id Id of message
     *
     * @return JsonResponse
     */
    public function fetchOne(int $id) : JsonResponse
    {
        return response()->json(Message::find($id));
    }

    /**
     * Create a new message
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
        $user = Message::create(request()->all());
        return response()->json($user, 201);
    }

    /**
     * Update an existing message
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request) : JsonResponse
    {
        $this->validate(request(), [
            'message' => 'required'
        ]);
        $user = Message::findOrFail($id);
        $user->update(request()->all());

        return response()->json($user, 200);

    }

    /**
     * Delete a message
     *
     * @param int $id
     *
     * @return ResponseFactory
     */
    public function delete(int $id) : ResponseFactory
    {
        Message::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);

    }
}