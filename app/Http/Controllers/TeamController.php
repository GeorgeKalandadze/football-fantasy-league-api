<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function __construct(protected TeamService $teamService)
    {

    }

    public function index(): JsonResponse
    {
        $teams = $this->teamService->getAllTeams();

        return response()->json(['teams' => $teams], 200);
    }

    public function store(TeamRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $message = $this->teamService->create($validatedData);

        return response()->json(['message' => $message], 201);
    }

    public function show(Team $team): JsonResponse
    {
        $team = $this->teamService->getById($team->id);
        if ($team) {
            return response()->json(['team' => $team], 200);
        } else {
            return response()->json(['message' => 'Team not found'], 404);
        }
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        $validatedData = $request->validated();

        $response = $this->teamService->update($team->id, $validatedData);

        return response()->json(['response' => $response], 200);
    }

    public function destroy(Team $team): JsonResponse
    {
        $response = $this->teamService->delete($team->id);

        return response()->json(['response' => $response], 200);
    }
}
