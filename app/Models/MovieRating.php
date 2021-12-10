<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Recon\Helpers\InteractionBuilder;

class MovieRating extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function toReconInteractionBuilder()
    {
        return InteractionBuilder::make('RATING')
            ->setClientId($this->id)
            ->setItemId($this->movie_id)
            ->setValue($this->rating)
            ->setUserId($this->user_id)
            ->setTimestamp($this->created_at)
        ;
    }
}
