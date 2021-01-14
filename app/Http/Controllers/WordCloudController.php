<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Other\Tokenizers\NGram;
use Rubix\ML\Transformers\TfIdfTransformer as TransformersTfIdfTransformer;
use Rubix\ML\Transformers\WordCountVectorizer;

class WordCloudController extends Controller
{
    public function index()
    {
        $trainings = Tweet::select('word_cloud', 'emotion')->join('classifications','tweets.id','tweet_id')->where('emotion', request()->emotion)->get();        
        foreach ($trainings as $training) {
            $trainingSamples[] = [$training->word_cloud];
            $trainingLabels[] = $training->emotion;
        }
        $wordCountVectorizer = new WordCountVectorizer(10000, 5, 10000, new NGram(1, 3));
        $tfidf = new TransformersTfIdfTransformer();
        $training = Labeled::build($trainingSamples, $trainingLabels)
        ->apply($wordCountVectorizer)
        ->apply($tfidf);
        
        $topKeyword = array();
        foreach ($training->samples() as $rows) {
            foreach ($rows as $key => $row) {
                array_key_exists($key, $topKeyword) ? $topKeyword[$key] += $row : $topKeyword[$key] = $row;
            }
        }
        foreach ($topKeyword as $key => $value) {
            $keyword_score[$key]['word'] = $wordCountVectorizer->vocabularies()[0][$key];
            $keyword_score[$key]['score'] = $value;
        }        

        //Sort higher to lower
        usort($keyword_score, function ($a, $b) {
            return $a['score'] <=> $b['score'];
        });

        $keyword_score = array_reverse($keyword_score);        
        $sum = 0;
        $limit = count($keyword_score) < 20 ? count($keyword_score) : 20;        
        for ($i = 0; $i < $limit; $i++) {
            $result[] = [$keyword_score[$i]['word'], $keyword_score[$i]['score']];
            $sum += $keyword_score[$i]['score'];
        }    
        foreach ($result as $key => $value) {
            $result[$key][1] = $result[$key][1] / $sum * 600;
        }        
        return $result;
    }
}
