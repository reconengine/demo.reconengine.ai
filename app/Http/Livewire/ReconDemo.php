<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ReconDemo extends Component
{
    public $search;

    protected $queryString = ['search'];

    public $displayingRelatedArticle = false;
    public $relatedArticles = null;
    public $displayingArticle = false;
    public $selectedArticle = null;

    public function render()
    {
        return view('livewire.recon-demo', [
            'articles' => Article::where('title', 'like', '%'.$this->search.'%')
                ->orWhere('text', 'like', '%'.$this->search.'%')
                ->limit(20)
                ->get(),
        ]);
    }

    public function articleSelected(Article $article)
    {
        $this->displayingArticle = true;
        $this->displayingRelatedArticle = false;
        $this->selectedArticle = $article;
    }

    public function displayRelatedArticles(Article $article)
    {
        $this->displayingArticle = false;
        $this->displayingRelatedArticle = true;
        $this->selectedArticle = $article;
//        $relatedArticleResponse = $article->related();
//        dd($relatedArticleResponse);
//        $relatedArticleIds = collect($relatedArticleResponse['items'])->pluck('item_id');
        $this->relatedArticles = Article::join('related_articles', 'related_articles.related_article_id', 'articles.id')
            ->where('related_articles.source_article_id', $article->id)
            ->orderByAsc('related_articles.id')
            ->get();
    }
}
