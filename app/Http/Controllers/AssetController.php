<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class AssetController extends Controller
{
    public function loadAssets()
    {
        $assets = Asset::all();
        
        while ($assets->isEmpty()) {
            sleep(5);
            $assets = Asset::all();
        }
        return $assets;
    }
}
