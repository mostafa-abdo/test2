<?php

namespace App\Http\Resources;

use App\Models\BlogState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $datecurrent = $this->created_at;

        $date = new \DateTime($datecurrent);

        setlocale(LC_ALL, 'ar');

        $formatted_date = $date->format('Y-m-d');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'state' => BlogState::where('id', $this->state_id)->first()->name,
            'image' => $this->image ? URL::to($this->image) : null,
            'updated_at' => $formatted_date,
            'views' => $this->views,
        ];
    }
}
