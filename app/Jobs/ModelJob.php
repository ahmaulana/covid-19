<?php

namespace App\Jobs;

use App\Models\Dataset;
use App\Models\DModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Rubix\ML\Classifiers\GaussianNB;
use Rubix\ML\CrossValidation\Reports\AggregateReport;
use Rubix\ML\CrossValidation\Reports\ConfusionMatrix;
use Rubix\ML\CrossValidation\Reports\MulticlassBreakdown;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Other\Tokenizers\NGram;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Pipeline;
use Rubix\ML\Transformers\TfIdfTransformer;
use Rubix\ML\Transformers\WordCountVectorizer;

class ModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $trainingSamples, $trainingLabels, $testingSamples, $testingLabels, $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->trainingSamples = [];
        $this->trainingLabels = [];
        $this->testingSamples = [];
        $this->testingLabels = [];
        $this->data = $data;              
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $trainings = Dataset::select('text_prepro', 'label')->where('type','training')->get();
        $testings = Dataset::select('text_prepro', 'label')->where('type','testing')->get();

        //Training
        foreach ($trainings as $training) {
            $this->trainingSamples[] = [$training->text_prepro];
            $this->trainingLabels[] = $training->label;
        }
        
        //Testing
        foreach ($testings as $testing) {
            $this->testingSamples[] = [$testing->text_prepro];
            $this->testingLabels[] = $testing->label;
        }

        $training = Labeled::build($this->trainingSamples, $this->trainingLabels);
        $testing = Labeled::build($this->testingSamples, $this->testingLabels);
        
        $estimator = new PersistentModel(
            new Pipeline([
                new WordCountVectorizer(10000, 3, 10000, new NGram(1, 2)),
                new TfIdfTransformer(),
            ], new GaussianNB()),
            new Filesystem(storage_path() . '/model/' . $this->data['model_name'] . '.model', true)
        );

        $estimator->train($training);

        $predictions = $estimator->predict($testing);

        //Report    
        $report = new AggregateReport([
            new MulticlassBreakdown(),
            new ConfusionMatrix(),
        ]);
        $results = $report->generate($predictions, $testing->labels());
        $estimator->save();

        //Check Active Model
        $actived = DModel::count() == 0 ? 1 : 0;

        //Save to DB
        $fix_model = DModel::create([        
            'model_name' => $this->data['model_name'],
            'model_desc' => $this->data['model_desc'],
            'accuracy' => $results[0]['overall']['accuracy'],
            'actived' => $actived
        ]);
    }
}