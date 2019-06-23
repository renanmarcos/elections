<?php

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

Route::get('/', function () {
    $candidates = \App\Models\Candidate::all();
    if ($candidates->count() == 0) {
        return view('welcome')->with('renderChart', false);
    }

    $votes = \Lava::DataTable();
    $votes->addStringColumn('Nome')->addNumberColumn('Votos');

    foreach ($candidates as $candidate) {
        $votes->addRow([$candidate->name, $candidate->votes]);
    }

    \Lava::ColumnChart('Votes', $votes, [
        'title' => 'Resultado temporário das eleições',
        'titleTextStyle' => [
            'color'    => '#eb6b2c',
            'fontSize' => 14
        ]
    ]);

    return view('welcome')->with('renderChart', true);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/candidates', 'CandidateController@index');
Route::post('/candidates', 'CandidateController@store');
Route::post('/candidates/{candidateNumber}', 'CandidateController@computeVote');
Route::get('/votes', 'CandidateController@index');
