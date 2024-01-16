<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PostsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Post([
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => 1,
            'created_user_id' => auth()->user()->id,
            'updated_user_id' => auth()->user()->id,
            'deleted_user_id' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
