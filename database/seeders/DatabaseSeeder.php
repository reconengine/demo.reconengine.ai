<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpFaker();
        self::importArticles();
        self::importInteractions();
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

            echo "Processing line ({$i}): {$filedata[10]}\n";
            $user = User::firstOrCreate([
                'external_user_id' => $filedata[3],
            ], [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->email,
                'password' => bcrypt('test1234'),
            ]);

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
            // Skip first row (Remove below comment if you want to skip the first row)
            if($i == 0){
                $i++;
                continue;
            }

            $i++;

            echo "Processing line ({$i}): {$filedata[1]}\n";
            $user = User::firstOrCreate([
                'external_user_id' => $filedata[3],
            ], [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->email,
                'password' => bcrypt('test1234'),
            ]);

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
