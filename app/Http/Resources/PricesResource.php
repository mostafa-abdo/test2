<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class PricesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'sonata_price' => $this->sonata_price,
            'gms_price' => $this->gms_price,
            'h1_price' => $this->h1_price,
            'ford_price' => $this->ford_price,
            'lexus_price' => $this->lexus_price,
            'mercedes_price' => $this->mercedes_price,
        ];
    }
}
