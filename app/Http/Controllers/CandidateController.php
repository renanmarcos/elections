<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;

class CandidateController extends Controller
{
    /**
     * Store a new Candidate
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'candidate_number' => 'required'
        ]);

        $data = $request->only('name', 'candidate_number');
        Candidate::create($data);

        return view('candidates')->with(['success', 'Candidato criado com sucesso!', 'candidates' => Candidate::all()]);
    }

    /**
     * Compute vote
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Candidate $candidate
     */
    public function computeVote(Request $request, int $candidateNumber)
    {
        $candidates = Candidate::all();

        if (!$candidate = Candidate::whereCandidateNumber($candidateNumber)->first()) {
            return redirect('votes')->with(['error' => 'Candidato não encontrado.', 'candidates' => $candidates]);
        }

        $candidate->update([
            'votes' => ++$candidate->votes
        ]);

        return view('votes')->with(['success' => 'Voto computado com sucesso.', 'candidates' => $candidates]);
    }

    /**
     * Show Candidates/Votes view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uri = trim(\Request::getRequestUri(), "/");
        $candidates = Candidate::all();

        return view($uri)->with('candidates', $candidates);
    }
}
