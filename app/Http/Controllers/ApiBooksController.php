<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class ApiBooksController extends Controller
{
    public function index(){
        if(request()->has('_limit')){
            $books = Book::limit(request()->_limit)->get();
        }else {
            $books = Book::get();
        }

        return response($books, 200);
    }
}