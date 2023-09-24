<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MusicController extends BaseController
{   
    private $music;
    public function __construct()
    {
        $this->music = new \App\Models\MusicModel();
    }

    public function save()
    {   
        $id =$_POST['id'];
        $data = [
            'name' => $this->request->getVar('name'),
            'audio' => $this->request->getVar('audio'),
        ];
        
        $this->music->save($data);
        return redirect()->to('/music');
    }

    public function music($music)
    {
        echo $music;
    }

    public function montellano()
    {
        $data['music'] = $this->music->findAll();
        return view('musics', $data);
    }

    public function index()
    {
        //
    }
}
