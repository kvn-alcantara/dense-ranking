<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'scores' => ScoreResource::collection($this->whenLoaded('scores')),
            '_links' => [
                [
                    'href' => route('scores.index', $this),
                    'rel' => 'ranking',
                    'type' => 'GET',
                ],
                $this->mergeWhen(auth()->user()->hasRoles(['admin']), [
                    [
                        'href' => route('games.update', $this),
                        'rel' => 'update',
                        'type' => 'PUT',
                    ],
                    [
                        'href' => route('games.destroy', $this),
                        'rel' => 'destroy',
                        'type' => 'DELETE',
                    ],
                ]),
            ],
        ];
    }
}
