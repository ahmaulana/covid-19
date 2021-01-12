<?php

use App\Events\ChartEvent;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WordCloudController;
use App\Models\Dataset;
use App\Models\Stopword;
use App\Preprocessing\PreprocessingService;
use Backpack\CRUD\app\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AdminController::class, 'dashboard'])->name('backpack.dashboard');
Route::get('klasifikasi', [AdminController::class, 'classification'])->name('backpack.classification');
Route::post('classification-process', [AdminController::class, 'classification_process'])->name('classification.process');
Route::get('/admin', [AdminController::class, 'redirect'])->name('backpack');

Route::post('/chart/read-data', [ChartController::class, 'index'])->name('chart.read');
Route::post('/word-cloud', [WordCloudController::class, 'index'])->name('word.cloud');

Route::get('/prepro', function () {
    $keyword = ["WNI Telah Divaksin Covid-19, Phita Beberkan Kondisinya Usai Mendapatkan Vaksinasi di Inggris | tvOne https://t.co/RBZZ8t34DS"];
    $result = PreprocessingService::index($keyword);
    dd($result[0]['result']);
});

Route::get('/keyword', function () {
    $samples = Dataset::select("textPrepro")->take(10)->get()->toArray();
    foreach ($samples as $sample) {
        $data[] = $sample['textPrepro'];
    }

    $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer);

    // Build the dictionary.
    $vectorizer->fit($data);

    // Transform the provided text samples into a vectorized list.
    $vectorizer->transform($data);
    $word = $vectorizer->getVocabulary();

    // return $samples = [
    //    [0 => 1, 1 => 1, 2 => 2, 3 => 1, 4 => 1],
    //    [5 => 1, 6 => 1, 1 => 1, 2 => 1],
    //    [5 => 1, 7 => 2, 8 => 1, 9 => 1],
    //];
    $transformer = new TfIdfTransformer($data);
    $transformer->transform($data);
    $topKeyword = array();
    foreach ($data as $rows) {
        foreach ($rows as $key => $row) {
            array_key_exists($key, $topKeyword) ? $topKeyword[$key] += $row : $topKeyword[$key] = $row;
        }
    }
    $arr = array_combine($word, $topKeyword);
    arsort($arr);
    dd($arr);
});

Route::get('/stopword', function () {
    $words = [['stopword' => 'yang'], ['stopword' => 'untuk'], ['stopword' => 'pada'], ['stopword' => 'ke'], ['stopword' => 'para'], ['stopword' => 'namun'], ['stopword' => 'menurut'], ['stopword' => 'antara'], ['stopword' => 'dia'], ['stopword' => 'dua'], ['stopword' => 'ia'], ['stopword' => 'seperti'], ['stopword' => 'jika'], ['stopword' => 'jika'], ['stopword' => 'sehingga'], ['stopword' => 'kembali'], ['stopword' => 'dan'], ['stopword' => 'tidak'], ['stopword' => 'ini'], ['stopword' => 'karena'], ['stopword' =>'kepada'], ['stopword' => 'oleh'], ['stopword' => 'saat'], ['stopword' => 'harus'], ['stopword' => 'sementara'], ['stopword' => 'setelah'], ['stopword' => 'belum'], ['stopword' => 'kami'], ['stopword' => 'sekitar'], ['stopword' => 'bagi'], ['stopword' => 'serta'], ['stopword' => 'di'], ['stopword' => 'dari'], ['stopword' => 'telah'], ['stopword' => 'sebagai'], ['stopword' => 'masih'], ['stopword' => 'hal'], ['stopword' => 'ketika'], ['stopword' => 'adalah'], ['stopword' => 'itu'], ['stopword' => 'dalam'], ['stopword' => 'bisa'], ['stopword' => 'bahwa'], ['stopword' => 'atau'], ['stopword' => 'hanya'], ['stopword' => 'kita'], ['stopword' => 'dengan'], ['stopword' => 'akan'], ['stopword' => 'juga'], ['stopword' => 'ada'], ['stopword' => 'mereka'], ['stopword' => 'sudah'], ['stopword' => 'saya'], ['stopword' => 'terhadap'], ['stopword' => 'secara'], ['stopword' => 'agar'], ['stopword' => 'lain'], ['stopword' => 'anda'], ['stopword' => 'begitu'], ['stopword' => 'mengapa'], ['stopword' => 'kenapa'], ['stopword' => 'yaitu'], ['stopword' => 'yakni'], ['stopword' => 'daripada'], ['stopword' => 'itulah'], ['stopword' => 'lagi'], ['stopword' => 'maka'], ['stopword' => 'tentang'], ['stopword' => 'demi'], ['stopword' => 'dimana'], ['stopword' => 'kemana'], ['stopword' => 'pula'], ['stopword' => 'sambil'], ['stopword' => 'sebelum'], ['stopword' => 'sesudah'], ['stopword' => 'supaya'], ['stopword' => 'guna'], ['stopword' => 'kah'], ['stopword' => 'pun'], ['stopword' => 'sampai'], ['stopword' => 'sedangkan'], ['stopword' => 'selagi'], ['stopword' => 'sementara'], ['stopword' => 'tetapi'], ['stopword' => 'apakah'], ['stopword' => 'kecuali'], ['stopword' => 'sebab'], ['stopword' => 'selain'], ['stopword' => 'seolah'], ['stopword' => 'seraya'], ['stopword' => 'seterusnya'], ['stopword' => 'tanpa'], ['stopword' => 'agak'], ['stopword' => 'boleh'], ['stopword' => 'dapat'], ['stopword' => 'dsb'], ['stopword' => 'dst'], ['stopword' => 'dll'], ['stopword' => 'dahulu'], ['stopword' => 'dulunya'], ['stopword' => 'anu'], ['stopword' => 'demikian'], ['stopword' => 'tapi'], ['stopword' => 'ingin'], ['stopword' => 'juga'], ['stopword' => 'nggak'], ['stopword' => 'mari'], ['stopword' => 'nanti'], ['stopword' => 'melainkan'], ['stopword' => 'oh'], ['stopword' => 'ok'], ['stopword' => 'seharusnya'], ['stopword' => 'sebetulnya'], ['stopword' => 'setiap'], ['stopword' => 'setidaknya'], ['stopword' => 'sesuatu'], ['stopword' => 'pasti'], ['stopword' => 'saja'], ['stopword' => 'toh'], ['stopword' => 'ya'], ['stopword' => 'walau'], ['stopword' => 'tolong'], ['stopword' => 'tentu'], ['stopword' => 'amat'], ['stopword' => 'apalagi'], ['stopword' => 'bagaimanapun']];

    Stopword::insert($words);
});