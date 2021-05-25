<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    $posts = Post::all();

    return response()->json([
        'success' => true,
        'result' => $posts
    ]);
}
