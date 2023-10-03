<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MusicModel;
use App\Models\PlaylistModel;
use App\Models\SongPlaylistModel;

class MusicController extends BaseController
{
    private $playlist;
    private $music;
    private $musicplaylist;

    public function __construct()
    {
        $this->playlist = new PlaylistModel();
        $this->music = new MusicModel();
        $this->musicplaylist = new SongPlaylistModel();
    }
    public function index()
    {
        $data['playlists'] = $this->playlist->findAll();
        $data['music'] = $this->music->findAll();
        return view('musics', $data);
    }
    public function create()
    {
        $data = [
            'name' => $this->request->getPost('name')
        ];
        $this->playlist->insert($data);
        return redirect()->to('/musics');
    }

    public function playlists($id)
    {
        $playlist = $this->playlist->find($id);
    
        if ($playlist) {
            $musicplaylist = $this->musicplaylist->where('playlist_id', $id)->findAll();
            $music = [];
            foreach ($musicplaylist as $track) {
                $musicItem = $this->music->find($track['music_id']);
                if ($musicItem) {
                    $music[] = $musicItem;
                }
            }
            $data = [
                'playlist' => $playlist,
                'music' => $music,
                'playlists' => $this->playlist->findAll(),
                'musicplaylist' => $musicplaylist,
            ];
    
            
    
            return view('musics', $data);
        } else {
           return redirect()->to('/musics');
        }
    }
    

    public function search()
    {
        $search = $this->request->getGet('songname');
        $musicResults = $this->music->like('songname', '%' . $search . '%')->findAll();
        $data = [
            'playlists' => $this->playlist->findAll(),
            'music' => $musicResults,
        ];
        return view('musics', $data);
    }
    public function add()
    {

        $musicID = $this->request->getPost('musicID');
        $playlistID = $this->request->getPost('playlist');

        $data = [
            'playlist_id' => $playlistID,
            'music_id' => $musicID,
        ];
        $this->musicplaylist->insert($data);
        return redirect()->to('/musics');
    }

    public function upload()
    {
        $file = $this->request->getFile('file');
        $songname = $this->request->getPost('songname');
        $artist = $this->request->getPost('artist');
        $newName = $songname . '_' . $artist . '.' . 'mp3';
        $file->move(ROOTPATH . 'public/', $newName);
        $data = [
            'songname' => $songname,
            'artist' => $artist,
            'file_path' => $newName
        ];
        $this->music->insert($data);
        return redirect()->to('/musics');
    }
    
}
