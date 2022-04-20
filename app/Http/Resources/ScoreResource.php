<?php

namespace App\Http\Resources;

use App\Models\Role;
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
            'id' => $this->id,
            'position' => $this->position,
            'value' => $this->value,
            'player' => [
                'user_id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            '_links' => [
                [
                    'href' => route('scores.show', $this),
                    'rel' => 'show',
                    'type' => 'GET',
                ],
                $this->mergeWhen(auth()->user()->hasRoles([Role::ADMIN]), [
                    [
                        'href' => route('scores.update', $this),
                        'rel' => 'update',
                        'type' => 'PUT',
                    ],
                ]),
                $this->mergeWhen(auth()->id() == $this->user_id, [
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
