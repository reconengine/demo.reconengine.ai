<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Interaction;
use App\Models\RelatedArticle;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\WithFaker;

class SaveRelatedArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:related';

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
        RelatedArticle::truncate();

        Article::each(function (Article $article) {

            $relatedArticles = $article->related();

        });

        return 0;
    }
}
