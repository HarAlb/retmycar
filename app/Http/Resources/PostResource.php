<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'city' => CityResource::make($this->whenLoaded('city')),
            'model' => ModelResource::make($this->whenLoaded('model')),
            'seats' => $this->seats,
            'price' => floatval($this->price),
            'transmission' => $this->transmission,
            'fuel' => $this->fuel,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at,
            'user' => $this->whenLoaded('user'),
            'is_favorite' => $this->whenLoaded('favoritedByUsers', function () {
                return $this->favoritedByUsers->contains(auth()->id());
            }),
        ];
    }
}
