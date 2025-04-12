<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
  /**
     * @OA\Get(
     *     path="/api/newsletters",
     *     summary="Get all newsletters",
     *     tags={"Newsletters"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="A list of newsletters",
     *     )
     * )
     */  
    public function index()
    {
        $newsletters = Newsletter::all();

        return response()->json($newsletters);
    }

    /**
     * @OA\Post(
     *     path="/api/newsletters",
     *     summary="Create a new newsletter",
     *     tags={"Newsletters"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Newsletter created successfully",
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
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        try {
            $newsletter = Newsletter::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
            ]);
            return response()->json($newsletter, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
/**
     * @OA\Get(
     *     path="/api/newsletters/{id}",
     *     summary="Get a single newsletter",
     *     tags={"Newsletters"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of a newsletter",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Newsletter not found"
     *     )
     * )
     */
    public function show($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        return response()->json($newsletter);
    }

   /**
     * @OA\Put(
     *     path="/api/newsletters/{id}",
     *     summary="Update a newsletter",
     *     tags={"Newsletters"},
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
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter updated successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Newsletter not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->update($validated);

        return response()->json([
            'message' => 'newsletter updated',
            'newsletter' => $newsletter
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/newsletters/{id}",
     *     summary="Delete a newsletter",
     *     tags={"Newsletters"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Newsletter not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return response()->json([
            'message' => 'newsletter deleted',
        ]);
    }
}
