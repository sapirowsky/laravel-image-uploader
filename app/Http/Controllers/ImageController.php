<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index(){
        return view('images.index');
    }
    public function show(){
        // return all imagas
        return Image::latest()->pluck('name')->toArray();
    }
    public function store(Request $request){
        // validate request
        if(!$request->hasFile('image')){
            return response()->json(['error' => 'There is no image present'], 400);
        }

        $request->validate([
            'image' => 'required|file|image'
        ]);

        // store image
        $path = $request->file('image')->store('public/images');

        if(!$path ){
            return response()->json(['error' => 'The file could not be saved.'], 500);
        }
        $uploadedFile = $request->file('image');
        // Create image model
        $image = Image::create([
            'name' => $uploadedFile->hashName(),
            'ext' => $uploadedFile->extension(),
            'size' => $uploadedFile->getSize(),
        ]);

        // return image model
        return $image->name;
    }
}
