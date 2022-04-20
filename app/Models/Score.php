<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Score
 *
 * @property int $id
 * @property int $game_id
 * @property int $user_id
 * @property int $value
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Game $game
 * @property-read User $user
 * @mixin Eloquent
 */
class Score extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'user_id',
        'value',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ordered-by-position', function (Builder $builder) {
            $builder->orderBy('position')
                    ->orderBy('created_at');
        });
    }

    /**
     * Get the game that owns the score.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the user that owns the score.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
