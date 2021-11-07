<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table                = 'posts';
    protected $primaryKey           = 'post_id';
    protected $allowedFields        = ['judul', 'deskripsi', 'gambar', 'author', 'kategori', 'slug', 'created_at', 'updated _at'];
    // Dates
    protected $useTimestamps        = true;

    public function getPost($slug)
    {
        return $this->where(['slug' => $slug])->first();
    }
}
