<?php

namespace App\Contracts\Dao\Post;

use Illuminate\Http\Request;

interface PostDaoInterface
{
  /**
   * To get post list
   */
  public function getPostList(Request $request);

  public function savePost(Request $request);

  public function deletePostById($id, $deletedUserId);

  public function getPostById($id);

  public function updatedPostById(Request $request, $id);

  public function uploadPostCSV($validated, $uploadedUserId);

}
