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

    /* TODO: Where com o asset_id */
    public function loadAssetData($asset){
        $assetData = OpenPositions::where('asset_id', $asset)
        ->orderBy('date')
        ->take(20)
        ->get();
        
        return $assetData;
    }
}
