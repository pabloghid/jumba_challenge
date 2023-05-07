<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpenPositionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date,
            'tracker_symbol' => $this->tracker_symbol,
            'asset' => $this->asset,
            'balance_quantity' => $this->balance_quantity,
            'trade_average_price' => $this->trade_average_price,
            'balance_value' => $this->balance_value
        ];
    }
}
