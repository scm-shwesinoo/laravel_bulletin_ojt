<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

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
        $data = DB::table('posts as post')
        ->join('users as created_user', 'post.created_user_id', '=', 'created_user.id')
        ->join('users as updated_user', 'post.updated_user_id', '=', 'updated_user.id')
        ->select('post.title', 'post.description', 'created_user.name as created_user', 'post.created_at')
        ->whereNull('post.deleted_at');
        if (!Auth::check()) {
          $data = $data->where('post.status', 1);
        } else {
          $authType = Auth::user()->type;
          if ($authType == 1) {
              $data = $data->where(function (Builder $query) {
                      $query->where('post.created_user_id', Auth::user()->id)
                            ->orWhere('post.status', '1');
              });
            }
          }
          if ($this->request) {
              $data = $data->where(function (Builder $query){
                      $query->where('post.title', 'like', '%' . trim($this->request) . '%')
                            ->orWhere('post.description', 'like', '%' . trim($this->request) . '%');
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
