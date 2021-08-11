<?php

namespace App\Console\Commands;

use App\Models\Interaction;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Recon\Helpers\InteractionBuilder;

class ImportInteractions extends Command
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
        Interaction::chunk(250, function (Collection $interactions) {
            $topId = $interactions->last()->id;
            $this->line("Importing interactions up to ID: {$topId}");

            $interactionBuilders = $interactions->map->toReconInteractionBuilder();

            InteractionBuilder::sendBatch($interactionBuilders);
        });

        return 0;
    }
}
