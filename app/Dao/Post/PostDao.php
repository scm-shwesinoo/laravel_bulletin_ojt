<?php

namespace App\Dao\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PostsImport;

class PostDao implements PostDaoInterface
{
  public function getPostList(Request $request)
  {
    $pageSize = $request->input('page_size', 10);
    $data = Post::whereNull('deleted_at');
      if (!Auth::check()) {
        $data = $data->where('status', 1);
      } else {
        $authType = Auth::user()->type;
        if ($authType == 1) {
          $data = $data->where(function ($query) {
                    $query->where('created_user_id', auth()->user()->id)
                    ->orWhere('status', '1');
          });
        }
      }
    if (request()->has('search')) {
      $data = $data->where(function ($query) use ($request){
                    $query->where('title', 'like', '%' . trim($request->search) . '%')
                    ->orWhere('description', 'like', '%' . trim($request->search) . '%');
      });
    }
    return $data->orderBy('id', 'desc')->paginate($pageSize);
  }

  public function savePost(Request $request)
  {
    $post = new Post();
    $post->title = request()->title;
    $post->description = request()->description;
    $post->created_user_id = Auth::user()->id ?? 1;
    $post->updated_user_id = Auth::user()->id ?? 1;
    $post->save();
    return $post;
  }

  public function deletePostById($id, $deletedUserId)
  {
    $post = Post::find($id);
    if ($post) {
      $post->deleted_user_id = $deletedUserId;
      $post->save();
      $post->delete();
      return 'Post Deleted Successfully!';
    }
    return 'Post Not Found!';
  }

  public function getPostById($id)
  {
    $post = Post::find($id);
    return $post;
  }

  public function updatedPostById(Request $request, $id)
  {
    $post = Post::find($id);
    $post->title = $request->title;
    $post->description = $request->description;
    if ($request->status) {
      $post->status = '1';
    } else {
      $post->status = '0';
    }
    $post->updated_user_id = Auth::user()->id;
    $post->save();
    return 'Post Updated Successfully!';
  }

  public function uploadPostCSV($validated, $uploadedUserId)
  {
    $fp = file($validated['csv_file']);
    if (count($fp) >= 2) {
        try {
          Excel::import(new PostsImport, $validated['csv_file']);
        } catch (\Illuminate\Database\QueryException $e) {
          $errorCode = $e->errorInfo[1];
          $duplicateTitle = $e->getBindings()[0];
          if ($errorCode == '1062') {
            $content = array(
              'isUploaded' => false,
              'message' => '"'.$duplicateTitle.'" is duplicated title.'
            );
            return $content;
          }
        }
    }
    else {
      // error handling for invalid row.
      $content = array(
        'isUploaded' => false,
        'message' => 'Please check CSV file records.'
      );
      return $content;
    }
    $content = array(
      'isUploaded' => true,
      'message' => 'Uploaded Successfully!'
    );
    return $content;
  }
}