<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\WithFaker;

class ImportArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:db';

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
//        $this->importArticles();
        $this->importInteractions();

        return 0;
    }

    public function importArticles()
    {
        // Import CSV to Database
        $filepath = storage_path('dataset/shared_articles.csv');

        // Reading file
        $file = fopen($filepath,"r");

        $i = 0;

        while (($filedata = fgetcsv($file)) !== FALSE) {
            $i++;
            // Skip first row (Remove below comment if you want to skip the first row)
            if($i == 0){
                continue;
            }

            if ($filedata[1] != 'CONTENT SHARED') {
                continue;
            }

            $this->line("Processing line ({$i}): {$filedata[10]}");
            $user = User::withoutEvents(function () use ($filedata) {
                return User::firstOrCreate([
                    'external_user_id' => $filedata[3],
                ]);
            });


            Article::withoutEvents(function () use ($filedata, $user) {
                Article::updateOrCreate([
                    'external_content_id' => $filedata[2],
                ], [
                    'title' => $filedata[10],
                    'text' => $filedata[11],
                    'event_type' => $filedata[1],
                    'user_id' => $user->id,
                    'content_type' => $filedata[8],
                    'url' => $filedata[9],
                    'created_at' => $filedata[0],
                ]);
            });
        }
        fclose($file);
    }

    public function importInteractions()
    {
        // Import CSV to Database
        $filepath = storage_path('dataset/users_interactions.csv');

        // Reading file
        $file = fopen($filepath,"r");

        $i = 0;

        while (($filedata = fgetcsv($file)) !== FALSE) {
            $i++;

            // Skip first row (Remove below comment if you want to skip the first row)
            if($i == 0){
                continue;
            }

            // already processed...
            if ($i < 28980) {
                continue;
            }


            $this->line("Processing line ({$i}): {$filedata[1]}");
            $user = User::withoutEvents(function () use ($filedata) {
                return User::firstOrCreate([
                    'external_user_id' => $filedata[3],
                ]);
            });

            $article = Article::firstWhere('external_content_id', $filedata[2]);

            if (! $article || ! $user) {
                continue;
            }

            Interaction::withoutEvents(function () use ($filedata, $user, $article) {
                Interaction::create([
                    'event_type' => $filedata[1],
                    'user_id' => $user->id,
                    'article_id' => $article->id,
                    'created_at' => $filedata[0],
                ]);
            });
        }
        fclose($file);
    }
}
