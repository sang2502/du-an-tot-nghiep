<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouForContacting;

use Illuminate\Http\Request;

class FeedbackClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.feedback.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submit(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'mess' => 'required|string',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

        $imagePath = null;
        if ($request->hasFile('img')) {
        $imagePath = 'feedback_images/' . $request->file('img')->hashName();
        $request->file('img')->storeAs('public/feedback_images', $request->file('img')->hashName());
    }

        Feedback::create([
        'name' => $request->name,
        'mess' => $request->mess,
        'img' => $imagePath,
    ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã phản hồi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
