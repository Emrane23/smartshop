<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::withTrashed()->with(['rating.customer', 'rating.product'])->latest()->get();
        return view('dashboard.comments.index', compact('comments'));
    }

    public function publish($id): JsonResponse
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        if ($comment->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Comment already processed.'], 400);
        }

        $comment->publish();
        return response()->json(['success' => true, 'message' => 'Comment published successfully.']);
    }

    public function destroy($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $comment->published_at = null ;
        $comment->save();
        $comment->delete();
        return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
    }

    public function restore($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        if ($comment->trashed()) {
            $comment->restore();
            $comment->published_at = null ;
            return response()->json(['success' => true, 'message' => 'Comment restored successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Comment is not deleted.'], 400);
    }

    public function setToPending($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->status === 'published') {
            $comment->published_at = null ;
            $comment->update();

            return response()->json([
                'success' => true,
                'message' => 'Comment status changed to pending.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Action not allowed.'
        ], 400);
    }
}
