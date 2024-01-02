<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsExport;

class PostService implements PostServiceInterface
{

  private $postDao;

  public function __construct(PostDaoInterface $postDao)
  {
    $this->postDao = $postDao;
  }

  public function getPostList(Request $request)
  {
    return $this->postDao->getPostList($request);
  }

  public function savePost(Request $request)
  {
    return $this->postDao->savePost($request);
  }

  public function deletePostById($id, $deletedUserId)
  {
    return $this->postDao->deletePostById($id, $deletedUserId);
  }

  public function getPostById($id)
  {
    return $this->postDao->getPostById($id);
  }

  public function updatedPostById(Request $request, $id)
  {
    return $this->postDao->updatedPostById($request, $id);
  }

  public function downloadPostCSV($search)
  {
    return Excel::download(new PostsExport($search), 'posts.csv');
  }
  
  public function uploadPostCSV($validated, $uploadedUserId)
  {
    return $this->postDao->uploadPostCSV($validated, $uploadedUserId);
  }
}
