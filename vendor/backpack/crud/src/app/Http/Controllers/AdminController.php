<?php

namespace Backpack\CRUD\app\Http\Controllers;

use App\Models\Classification;
use App\Models\DetailTweet;
use App\Models\DModel;
use App\Preprocessing\PreprocessingService;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

use function Amp\Iterator\toArray;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        if (!backpack_auth()->guest()) {
            $this->data['breadcrumbs'] = [
                trans('backpack::crud.admin')     => backpack_url('dashboard'),
                trans('backpack::base.dashboard') => false,
            ];
        }
        $last_date = Carbon::now()->toDateTimeString();
        $from = Carbon::parse($last_date)->subMinute(60)->toDateTimeString();
        $to = Carbon::parse($from)->addMinute(2)->toDateTimeString();
        for ($i = 0; $i < 30; $i++) {
            $emotion_list = Classification::select('emotion', DB::raw('count(*) as total'))
                ->join('tweets','tweet_id','tweets.id')->whereBetween('created_at', [$from, $to])->orderBy('emotion','DESC')->groupBy('emotion')
                ->get();            
            $label[] = $to;            
            $emotions['takut'][] = (isset($emotion_list[0]->total) ? $emotion_list[0]->total : 0);
            $emotions['cinta'][] = (isset($emotion_list[1]->total) ? $emotion_list[1]->total : 0);
            $emotions['marah'][] = (isset($emotion_list[2]->total) ? $emotion_list[2]->total : 0);
            $emotions['sedih'][] = (isset($emotion_list[3]->total) ? $emotion_list[3]->total : 0);
            $emotions['senang'][] = (isset($emotion_list[4]->total) ? $emotion_list[4]->total : 0);
            $from = Carbon::parse($to)->addSecond(1)->toDateTimeString();
            $to = Carbon::parse($from)->addMinute(2)->toDateTimeString();
        }
        $this->data['emotions_chart'] = ['label' => $label, 'emotion' => $emotions];

        //Count emotion
        $this->data['total'] = Classification::select(DB::raw('count(*) as total'))
            ->orderBy('emotion','DESC')->groupBy('emotion')
            ->get()->toArray();

        return view(backpack_view('dashboard'), $this->data);
    }

    public function classification()
    {
        $this->data['models'] = DModel::select('model_name')->get();
        $this->data['title'] = 'Klasifikasi'; // set the page title
        if (!backpack_auth()->guest()) {
            $this->data['breadcrumbs'] = [
                trans('backpack::crud.admin')     => backpack_url('classification'),
                trans('backpack::base.dashboard') => false,
            ];
        }

        return view(backpack_view('classification'), $this->data);
    }

    public function classification_process()
    {
        $data = request()->all();
        $pre_pro = PreprocessingService::index([$data['teks']]);        
        $estimator = PersistentModel::load(new Filesystem(storage_path() . '/model/' . $data['model'] . '.model'));
        $prediction = $estimator->predictSample([$pre_pro[0]['result']]);        
        return array($pre_pro[0]['result'], $prediction);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(url('/'));
    }
}
