<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Recon\Helpers\InteractionBuilder;

class Interaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function toReconInteractionBuilder()
    {
        return InteractionBuilder::make($this->event_type)
            ->setClientId($this->id)
            ->setItemId($this->article_id)
            ->setUserId($this->user_id)
            ->setTimestamp($this->created_at)
        ;
    }
}
