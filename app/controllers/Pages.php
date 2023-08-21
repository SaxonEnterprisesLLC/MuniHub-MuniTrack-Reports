<?php
    class Pages extends Controller {
        public function __construct() {
          
        }  

        public function index() {
            /*
            if (isLoggedIn()) {
                 redirect('reports');
             }
             */

            $data = [
                'title' => 'MuniHub MuniTrack Reports',
                'description' => 'MuniHub Reports built on the Saxon Reliance PHP Framework'
            ];
            $this->view('pages/index', $data);
        }
        
        public function about() {
            $data = [
                'title' => 'About Us',
                'description' => 'MuniHub MuniTrack Reports'
            ];
            $this->view('pages/about', $data);
        }
    }