<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Models\MovieRating;
use App\Models\RelatedMovie;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\WithFaker;

class SaveRelatedMovies extends Command
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
        RelatedMovie::truncate();

        Movie::each(function (Movie $article) {
            $this->line("Processing ID: {$article->id}");
            $relatedArticles = $article->related();

            foreach ($relatedArticles['items'] as $i => $item)
            {
                $relatedArticleId = $item['item_id'];
                RelatedMovie::create([
                    'source_article_id' => $article->id,
                    'related_article_id' => $relatedArticleId,
                    'order' => $i,
                ]);
            }
        });

        return 0;
    }
}
