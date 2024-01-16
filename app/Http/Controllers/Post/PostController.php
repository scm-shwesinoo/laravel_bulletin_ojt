<?php

namespace App\Http\Controllers\Post;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostUploadRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postInterface;

    public function __construct(PostServiceInterface $postServiceInterface)
    {
        $this->postInterface = $postServiceInterface;
    }

    public function showPostList(Request $request)
    {
        $pageSize = $request->page_size ?? 10;;
        $search = $request->description;
        $postList = $this->postInterface->getPostList($request);
        return view('posts.list', compact('postList', 'pageSize', 'search'));
    }

    public function showPostCreateView()
    {
        return view('posts.create');
    }

    public function submitPostCreateView(PostCreateRequest $request)
    {
        $validator = validator($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        return redirect()
            ->route('post.create.confirm')
            ->withInput();
    }

    public function showPostCreateConfirmView()
    {
        if (old()) {
            return view('posts.create-confirm');
        }
        return redirect()->route('postlist');
    }

    public function submitPostCreateConfirmView(Request $request)
    {
        $post = $this->postInterface->savePost($request);
        return redirect()->route('postlist')->with('success', 'Post created successfully!');
    }

    public function deletePostById(Request $request)
    {
        $postId = $request->post_id;
        $deletedUserId = auth()->user()->id;;
        $msg = $this->postInterface->deletePostById($postId, $deletedUserId);
        return redirect()->route('postlist')->with('info', $msg);
    }

    public function showPostEdit($postId)
    {
        $post = $this->postInterface->getPostById($postId);
        return view('posts.edit', compact('post'));
    }

    public function submitPostEditView(PostEditRequest $request, $postId)
    {
        $validator = validator($request->all());
        return redirect()
            ->route('post.edit.confirm', [$postId])
            ->withInput();
    }

    public function showPostEditConfirmView($postId)
    {
        if (old()) {
            return view('posts.edit-confirm');
        }
        return redirect()->route('postlist');
    }

    public function submitPostEditConfirmView(Request $request, $postId)
    {
        $msg = $this->postInterface->updatedPostById($request, $postId);
        return redirect()->route('postlist')->with('success', $msg);
    }

    public function downloadPostCSV(Request $request)
    {
        $search = $request->search;
        return $this->postInterface->downloadPostCSV($search);
    }

    public function showPostUploadView()
    {
        return view('posts.upload');
    }

    public function submitPostUploadView(PostUploadRequest $request)
    {
        $validated = $request->validated();
        $uploadedUserId = auth()->user()->id;;
        $content = $this->postInterface->uploadPostCSV($validated, $uploadedUserId);
        if (!$content['isUploaded']) {
            return redirect('/post/upload')->with('error', $content['message']);
        } else {
            return redirect()->route('postlist')->with('success', $content['message']);
        }
    }

    // public function index(Request $request)
    // {
    //     $pageSize = $request->input('page_size', 10);
    //     $filters = $request->only(['search']); // Get the filters from request parameters
    //     // dd($filters);
    //     $postList = Post::filter()->get();
    //     return view('posts.list', compact('postList', 'pageSize'));

    //     // $data = DB::table('posts as post');
    //     // $data = $data->where('post.title', 'like', '%' . $request->['title']) . '%')
    //     // ->orWhere('post.description', 'like', '%' . request()->get('search', '') . '%');
    // }


    // public function fileImportExport()
    // {
    //    return view('posts.file-import');
    // }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function fileImport(Request $request) 
    // {
        //dd($request->file('csv_file'));
        // Excel::import(new PostsImport, $request->file('csv_file'));
        // return redirect()->route('postlist');  
    // }

    // public function fileExport() 
    // {
    //     return Excel::download(new PostsExport, 'posts-collection.xlsx');
    // } 
}
