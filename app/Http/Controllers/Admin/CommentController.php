<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentController extends Controller
{
    public function destroy($id) {
        Comment::where('id', '=', $id)->orWhere('parent_comment_id', '=', $id)->delete();
        return redirect()->back();
    }
}
