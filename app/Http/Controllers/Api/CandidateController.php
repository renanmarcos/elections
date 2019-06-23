<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CandidateController extends Controller
{
    /**
     * Store a new Candidate
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'candidate_number' => 'required|unique:candidates|min:4|max:4'
        ]);

        if (!auth()->guard('api')->user()->hasPermissions()) {
            return $this->needPermissionResponse();
        }

        $data = $request->only('name', 'candidate_number');
        Candidate::create($data);

        return response()->json(['success' => 'Candidato criado com sucesso!'], Response::HTTP_CREATED);
    }

    /**
     * Compute vote
     *
     * @param \Illuminate\Http\Request $request
     * @param int $candidate
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function computeVote(Request $request, int $candidateNumber)
    {
        if (!$candidate = Candidate::whereCandidateNumber($candidateNumber)->first()) {
            return response()->json(['error' => 'Candidato não encontrado'], Response::HTTP_NOT_FOUND);
        }

        /** \App\Models\User $user */
        $user = auth()->guard('api')->user();

        if ($user->candidate_id) {
            return response()->json(['error' => 'Você já votou.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->candidate_id = $candidate->id;
        $user->save();

        $candidate->update([
            'votes' => ++$candidate->votes
        ]);

        return response()->json(['success' => 'Voto computado com sucesso.'], Response::HTTP_CREATED);
    }

    /**
     * Index candidates
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (!auth()->guard('api')->user()->hasPermissions()) {
            return $this->needPermissionResponse();
        }

        $candidates = Candidate::all();

        return response()->json($candidates);
    }

    /**
     * Update candidate
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Candidate $candidate
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Candidate $candidate)
    {
        if (!auth()->guard('api')->user()->hasPermissions()) {
            return $this->needPermissionResponse();
        }

        $data = $request->only('name', 'candidate_number');
        $candidate->update($data);

        return response()->json($candidate);
    }

    /**
     * Delete candidate
     *
     * @param \App\Models\Candidate $candidate
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Candidate $candidate)
    {
        if (!auth()->guard('api')->user()->hasPermissions()) {
            return $this->needPermissionResponse();
        }

        $candidate->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
    * Return need permission response
    *
    * @return \Illuminate\Http\JsonResponse
    */
    private function needPermissionResponse()
    {
        return response()->json(['error' => 'Você não tem permissão para isso.'], Response::HTTP_UNAUTHORIZED);
    }
}
