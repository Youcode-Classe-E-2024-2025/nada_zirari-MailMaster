<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    
    public function index()
    {
        $subscribers = Subscriber::all();

        return response()->json($subscribers);
    }

    
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

    
    public function show($id)
    {
        $subscriber = Subscriber::findOrFail($id);

        return response()->json($subscriber);
    }

   
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

   
   
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return response()->json('subscriber deleted');
    }
}
