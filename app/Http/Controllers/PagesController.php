<?php

namespace App\Http\Controllers;

class PagesController extends Controller {

    public function firstPage()
    {
        return view('page', [
            'title' => 'Title',
            'body' => 'BODY'
        ]);
    }
}