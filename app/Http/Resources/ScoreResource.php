<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
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
            'id',
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'value' => $this->value,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            '_links' => [
                $this->mergeWhen(auth()->id() === $this->user_id, [
                    [
                        'href' => route('scores.show', $this),
                        'rel' => 'show',
                        'type' => 'GET',
                    ],
                    [
                        'href' => route('scores.destroy', $this),
                        'rel' => 'destroy',
                        'type' => 'DELETE',
                    ],
                ]),
            ],
        ];
    }
}
