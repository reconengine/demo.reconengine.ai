<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Recon\Helpers\InteractionBuilder;

class Interaction extends Model
{
    use HasFactory;

    public function recordInteractionWithRecon()
    {
        InteractionBuilder::make($this->event_type)
            ->setItemId($this->article_id)
            ->setUserId($this->user_id)
            ->send()
        ;
    }
}
