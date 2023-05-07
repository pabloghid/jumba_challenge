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
        return OpenPositions::all('tracker_symbol');
    }
    public function loadAssetData($asset){
        $assetData = OpenPositions::where('tracker_symbol', $asset)->get();
        return $assetData;
    }
}
