<?php

namespace App\Console\Commands;

use App\Models\MovieRating;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Recon\Helpers\InteractionBuilder;

class ImportMovieRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:interactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MovieRating::chunk(250, function (Collection $interactions) {
            $firstId = $interactions->first()->id;
            $lastId = $interactions->last()->id;
            $this->line("Importing IDs: {$firstId} -> {$lastId}");

            $interactionBuilders = $interactions->map->toReconInteractionBuilder();

            InteractionBuilder::sendBatch($interactionBuilders);
        });

        return 0;
    }
}
