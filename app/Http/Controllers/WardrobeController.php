<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Support\Facades\Auth;

class WardrobeController extends Controller
{
    public function index()
    {
        $outfits = Outfit::where('user_id', Auth::id())->latest()->get();
        return view('wardrobe', compact('outfits'));
    }
}