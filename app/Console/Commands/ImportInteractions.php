<?php

namespace App\Console\Commands;

use App\Models\Interaction;
use Illuminate\Console\Command;

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
        Interaction::each(function (Interaction $interaction) {
            $this->line("Interaction: {$interaction->id}");
            dispatch(function () use ($interaction) {
                $interaction->recordInteractionWithRecon();
            });
        });

        return 0;
    }
}
