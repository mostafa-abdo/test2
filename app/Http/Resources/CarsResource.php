<?php

namespace App\Http\Resources;

use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class CarsResource extends JsonResource
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
            'name' => $this->name,
            'category' => CarCategory::find($this->category_id)->name ?? $this->category_id,
            'persons' => $this->persons,
            'bags' => $this->bags,
            'image' => $this->image ? URL::to($this->image) : null,
        ];
    }
}
