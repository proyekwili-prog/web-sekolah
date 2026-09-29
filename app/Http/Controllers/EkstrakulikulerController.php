<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkstrakulikulerController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Ekstrakulikuler'
        ];
        return view('admin.ekstrakulikuler.index', $data);
    }
    //
}
