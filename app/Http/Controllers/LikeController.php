<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $user = auth()->user();
        $postId = $request->post_id;

        $existingLike = Like::where('user_id', $user->id)
                            ->where('post_id', $postId)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return back()->with('success', 'Post unliked');
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $postId
        ]);

        return back()->with('success', 'Post liked');
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
        //
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
    public function destroy($id)
    {
        $like = Like::findOrFail($id);

        if ($like->user_id === auth()->id()) {
            $like->delete();
            return back()->with('success', 'Post unliked');
        }

        return back()->with('error', 'Unauthorized action');
    }
}
