<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;

class AdminPostsController extends BaseController
{
    public function __construct()
    {
        $this->PostModel = new PostModel();
    }

    public function index()
    {
        $PostModel = model("PostModel");
        $data = [
            'posts' => $PostModel->findAll()
        ];
        return view("posts/index", $data);
    }

    public function create()
    {
        session();
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        return view("posts/create", $data);
    }

    public function store()
    {
        $valid = $this->validate([
            "judul" => [
                "label" => "Judul",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "slug" => [
                "label" => "Slug",
                "rules" => "required|is_unique[posts.slug]",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                    "is_unique" => "{field} Sudah ada!",
                ]
            ],
            "kategori" => [
                "label" => "Kategori",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "author" => [
                "label" => "Author",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "deskripsi" => [
                "label" => "Deskripsi",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ]
        ]);
        // dd($valid);
        if ($valid) {
            $data = [
                'judul' => $this->request->getVar('judul'),
                'slug' => $this->request->getVar('slug'),
                'kategori' => $this->request->getVar('kategori'),
                'author' => $this->request->getVar('author'),
                'deskripsi' => $this->request->getVar('deskripsi'),
            ];
            $PostModel = model("PostModel");
            $PostModel->insert($data);
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');
            return redirect()->to(base_url('admin/posts/'));
        } else {
            $validation = \Config\Services::validation();
            return redirect()->to('admin/posts/create')->withInput()->with('validation', $validation);
        }
    }

    public function edit($slug)
    {
        session();
        $PostModel = model("PostModel");
        $data = [
            'validation' => \Config\Services::validation(),
            'post' => $PostModel->where('slug', $slug)->first()

        ];
        return view("posts/edit", $data);
    }

    public function update($post_id)
    {
        $valid = $this->validate([
            "judul" => [
                "label" => "Judul",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "slug" => [
                "label" => "Slug",
                "rules" => "required|is_unique[posts.slug]",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                    "is_unique" => "{field} Sudah ada!",
                ]
            ],
            "kategori" => [
                "label" => "Kategori",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "author" => [
                "label" => "Author",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ],
            "deskripsi" => [
                "label" => "Deskripsi",
                "rules" => "required",
                "errors" => [
                    "required" => "{field} Harus Diisi!",
                ]
            ]
        ]);

        if ($valid) {
            $data = [
                'judul' => $this->request->getVar('judul'),
                'slug' => $this->request->getVar('slug'),
                'kategori' => $this->request->getVar('kategori'),
                'author' => $this->request->getVar('author'),
                'deskripsi' => $this->request->getVar('deskripsi'),
            ];
            $PostModel = model("PostModel");
            $PostModel->update($post_id, $data);
            session()->setFlashdata('pesan', 'Data berhasil diubah!');
            return redirect()->to(base_url('admin/posts/'));
        } else {
            $validation = \Config\Services::validation();
            session()->setFlashdata('pesan1', 'Data tidak berhasil diubah!');
            return redirect()->to('admin/posts/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }
    }

    public function delete($post_id)
    {
        $this->PostModel->delete($post_id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/admin/posts');
    }
}
