<?php


namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class VotesController extends Controller
{
    public function submit(Request $request){

        return redirect('/')->with('success', 'Voto criado com sucesso!');
    }

    public function getCandidates(){
        $candidates = Candidate::all();
        return view('votes')->with('candidates', $candidates);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('votes');
    }
}