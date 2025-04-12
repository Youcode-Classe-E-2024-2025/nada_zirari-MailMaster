<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/subscribers",
     *     summary="Get all subscribers",
     *     tags={"Subscribers"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="A list of subscribers",
     *     )
     * )
     */ 
    public function index()
    {
        $subscribers = Subscriber::all();

        return response()->json($subscribers);
    }

     /**
     * @OA\Post(
     *     path="/api/subscribers",
     *     summary="Create a new subscriber",
     *     tags={"Subscribers"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "newsletter_id"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="newsletter_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subscriber created successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'newsletter_id' => 'required|exists:newsletters,id',
        ]);

        $subscriber = Subscriber::create($validated);

        return response()->json([
            'message' => 'subscriber strored',
            'subscriber' => $subscriber
        ], 201);
    }
  /**
     * @OA\Get(
     *     path="/api/subscribers/{id}",
     *     summary="Get a single subscriber",
     *     tags={"Subscribers"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of a Subscriber",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subscriber not found"
     *     )
     * )
     */
    
    public function show($id)
    {
        $subscriber = Subscriber::findOrFail($id);

        return response()->json($subscriber);
    }

   /**
     * @OA\Put(
     *     path="/api/subscribers/{id}",
     *     summary="Update a subscriber",
     *     tags={"Subscribers"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "newsletter_id"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="newsletter_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscriber updated successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subscriber not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'newsletter_id' => 'required|exists:newsletters,id',
        ]);

        $subscriber  = Subscriber::findOrFail($id);
        $subscriber->update($validated);

        return response()->json([
            'message' => 'subscriber updated',
            'subscriber' => $subscriber
        ]);
    }

   
   /**
     * @OA\Delete(
     *     path="/api/subscribers/{id}",
     *     summary="Delete a subscriber",
     *     tags={"Subscribers"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscriber deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subscriber not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return response()->json('subscriber deleted');
    }
}
