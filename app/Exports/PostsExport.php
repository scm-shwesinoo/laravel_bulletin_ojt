<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    private $request;
    public function __construct($request = null)
    {
        $this->request = $request;
    }
    public function collection()
    {
        $data = Post::select('title', 'description', 'created_user_id', 'created_at')->whereNull('deleted_at');
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
          if ($this->request) {
              $data = $data->where(function ($query){
                      $query->where('title', 'like', '%' . trim($this->request) . '%')
                            ->orWhere('description', 'like', '%' . trim($this->request) . '%');
            });
          }
    return $data->get();
    }

    public function headings(): array
    {
        return [
            'Title', 'Description', 'Posted User', 'Posted Date',
        ];

    }
}
