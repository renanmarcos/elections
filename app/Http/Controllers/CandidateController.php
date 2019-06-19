<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;

class CandidateController
{
    public function submit(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'candidate_number' => 'required'
        ]);
        $candidate = new Candidate();
        $candidate->name = $request->input('name');
        $candidate->candidate_number = $request->input('candidate_number');
        $candidate->save();

        return redirect('/')->with('success', 'Candidato criado com sucesso!');
    }
    public function getCandidates(){
        $candidates = Candidate::all();
        return view('candidates')->with('candidates', $candidates);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('candidates');
    }
}