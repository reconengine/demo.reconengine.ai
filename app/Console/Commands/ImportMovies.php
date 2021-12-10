<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Models\MovieRating;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;

class ImportMovies extends Command
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
//        $this->importMovies();
        $this->importMovieRatings();

        return 0;
    }

    public function importMovies()
    {
        Movie::query()->delete();

        // Import CSV to Database
        $filepath = storage_path('dataset/movies_metadata.csv');

        // Reading file
        $file = fopen($filepath,"r");
        fgetcsv($file); // Skip first row (Remove below comment if you want to skip the first row)

        $i = 0;

        while (($filedata = fgetcsv($file)) !== FALSE) {
            $i++;

            $this->line("Processing line ({$i}): {$filedata[8]}");

            if (! $filedata) {
                continue;
            }

            if (Movie::where('id', $filedata[5])->exists()) {
                continue;
            }

            if ($filedata[7] !== 'en') {
                continue;
            }

            Movie::withoutEvents(function () use ($filedata) {
                Movie::factory()->create([
                    'id' => $filedata[5],
                    'adult' => $filedata[0] === 'True',
                    'belongs_to_collection' => $filedata[1],
                    'budget' => $filedata[2],
                    'genres' => $filedata[3],
                    'homepage' => $filedata[4],
                    'language' => $filedata[7],
                    'title' => $filedata[20],
                    'text' => $filedata[9],
                    'popularity' => $filedata[10],
                    'production_companies' => $filedata[12],
                    'release_date' => $filedata[14],
                    'vote_average' => $filedata[22],
                    'vote_count' => $filedata[23],
                    'tagline' => $filedata[19],
                    'status' => $filedata[18],
                    'revenue' => $filedata[15],

                    'runtime' => is_numeric($filedata[16]) ? $filedata[16] : 0,
                ]);
            });
        }
        fclose($file);
    }

    public function importMovieRatings()
    {
        MovieRating::query()->delete();

        // Import CSV to Database
        $filepath = storage_path('dataset/ratings.csv');

        // Reading file
        $file = fopen($filepath,"r");
        fgetcsv($file); // Skip first row (Remove below comment if you want to skip the first row)

        $i = 0;

        while (($filedata = fgetcsv($file)) !== FALSE) {
            $i++;

            $this->line("Processing line ({$i})");

            if (! $filedata) {
                continue;
            }

            if (Movie::where('id', $filedata[1])->doesntExist()) {
                continue;
            }

            MovieRating::withoutEvents(function () use ($filedata) {
                MovieRating::factory()->create([
                    // userId,movieId,rating,timestamp
                    'rating' => $filedata[2],
                    'movie_id' => $filedata[1],
                    'user_id' => $filedata[0],
                    'created_at' => Carbon::createFromTimestamp($filedata[3])->toDateString(),
                ]);
            });
        }
        fclose($file);
    }
}
