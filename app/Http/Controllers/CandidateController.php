<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use \Illuminate\Validation\ValidationException;

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
        try {
            $this->validate($request, [
                'name' => 'required',
                'candidate_number' => 'required|unique:candidates'
            ]);
        } catch(ValidationException $e) {
            return redirect('candidates')->with(['error' => 'Número do candidato precisa ser único', 'candidates' => Candidate::all()]);
        };

        $data = $request->only('name', 'candidate_number');
        Candidate::create($data);

        return redirect('candidates')->with(['success' => 'Candidato criado com sucesso!', 'candidates' => Candidate::all()]);
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

        /** \App\Models\User $user */
        $user = \Auth::user();
        $user->candidate_id = $candidate->id;
        $user->save();

        $candidate->update([
            'votes' => ++$candidate->votes
        ]);

        return redirect('votes')->with(['success' => 'Voto computado com sucesso.', 'candidates' => $candidates]);
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
