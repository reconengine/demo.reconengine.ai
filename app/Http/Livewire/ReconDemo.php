<?php

namespace App\Http\Livewire;

use App\Models\Movie;
use Livewire\Component;

class ReconDemo extends Component
{
    public $search;

    protected $queryString = ['search'];

    public $displayingRelatedMovie = false;
    public $relatedMovies = null;
    public $displayingMovie = false;
    public $selectedMovie = null;

    public function render()
    {
        return view('livewire.recon-demo', [
            'movies' => Movie::where('title', 'like', '%'.$this->search.'%')
                ->orWhere('text', 'like', '%'.$this->search.'%')
                ->limit(20)
                ->get(),
        ]);
    }

    public function movieSelected(Movie $movie)
    {
        $this->displayingMovie = true;
        $this->selectedMovie = $movie;
    }

    public function displayRelatedMovies(Movie $movie)
    {
        $this->displayingRelatedMovie = true;
        $this->selectedMovie = $movie;
        $this->relatedMovies = Movie::select('movies.*')
            ->join('related_movies', 'related_movies.related_movie_id', 'movies.id')
            ->where('related_movies.source_movie_id', $movie->id)
            ->orderBy('related_movies.order')
            ->get()
        ;
    }
}
