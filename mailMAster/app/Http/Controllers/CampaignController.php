<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
   
    public function index()
    {
        $campaigns = Campaign::all();

        return response()->json($campaigns);
    }

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


    public function show($id)
    {
        $campain = Campaign::findOrFail($id);

        return response()->json($campain);
    }

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

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json('campaign deleted');
    }
}
