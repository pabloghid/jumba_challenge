<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenPositions;
use App\Http\Resources\OpenPositionsResource;

class OpenPositionController extends Controller
{
    public function index()
    {
        return OpenPositionsResource::collection(OpenPositions::all());
    }

    public function loadAssets()
    {
        $assets = OpenPositions::all('tracker_symbol');
        
        while ($assets->isEmpty()) {
            sleep(5);
            $assets = OpenPositions::all('tracker_symbol');
        }
        return $assets;
    }
    public function loadAssetData($asset){
        $assetData = OpenPositions::where('tracker_symbol', $asset)
        ->orderBy('date')
        ->take(20)
        ->get();
        
        return $assetData;
    }
}
