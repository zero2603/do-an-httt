<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Comment;

class CommentController extends Controller
{
    public function create(Request $request) {
        $data = $request->get('data');
        $comment = Comment::create($data);
        return redirect()->back();
    }
}
