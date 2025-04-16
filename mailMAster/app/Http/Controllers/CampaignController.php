<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/campaigns",
     *     summary="Get all campaigns",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="A list of campaigns",
     *     )
     * )
     */
    public function index()
    {
        $campaigns = Campaign::all();

        return response()->json($campaigns);
    }

    /**
     * @OA\Post(
     *     path="/api/campaigns",
     *     summary="Create a new campaign",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"subject", "content", "newsletter_id"},
     *             @OA\Property(property="subject", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="newsletter_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign created successfully",
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
            'subject' => 'required|string',
            'content' => 'required|string',
            'newsletter_id' => 'required|exists:newsletters,id',
        ]);

        $campaign = Campaign::create($validated);

        return response()->json([
            'message' => 'campaign strored',
            'campaign' => $campaign
        ], 201);
    }

 /**
     * @OA\Get(
     *     path="/api/campaigns/{id}",
     *     summary="Get a single campaign",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of a campaign",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function show($id)
    {
        $campain = Campaign::findOrFail($id);

        return response()->json($campain);
    }
/**
     * @OA\Put(
     *     path="/api/campaigns/{id}",
     *     summary="Update a campaign",
     *     tags={"Campaigns"},
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
     *             required={"subject", "content", "newsletter_id"},
     *             @OA\Property(property="subject", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="newsletter_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign updated successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
            'newsletter_id' => 'required|exists:newsletters,id',
        ]);

        $campaign = Campaign::findOrFail($id);
        $campaign->update($validated);

        return response()->json([
            'message' => 'campaign updated',
            'campaign' => $campaign
        ]);
    }
    /**
     * @OA\Delete(
     *     path="/api/campaigns/{id}",
     *     summary="Delete a campaign",
     *     tags={"Campaigns"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json('campaign deleted');
    }


    /**
      * @OA\Post(
      *     path="/api/campaigns/{id}/send",
      *     summary="Send a campaign to subscribers",
      *     operationId="sendCampaign",
      *     tags={"Campaigns"},
      *     @OA\Parameter(
      *         name="id",
      *         in="path",
      *         required=true,
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="Campaign sent successfully",
      *     ),
      *     @OA\Response(
      *         response=400,
      *         description="Invalid request"
      *     )
      * )
      */
      public function sendCampaign($id)
      {
          $campaign = Campaign::findOrFail($id);
  
          $subscribers = $campaign->newsletter->subscribers;
  
          foreach ($subscribers as $subscriber) {
              Mail::to($subscriber->email)->send(new CampaignMail($campaign));
          }
  
          return response()->json(['message' => 'Campaign sent successfully'], 200);
      }
}
