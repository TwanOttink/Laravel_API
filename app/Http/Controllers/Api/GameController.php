<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Game;

class GameController extends Controller
{
    public function getAllGames() {
        $games = Game::get()->toJson(JSON_PRETTY_PRINT);
        return response($games, 200);
    }

    public function getGame($id) {
        $games = Game::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($games, 200);
    }

    public function createGame(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'developer' => 'required|string|max:64',
            'publisher' => 'required|string|max:64',
        ]);

        $errors = $validation->errors();

        if ($validation->fails()) {
            return response()->json([
                "message" => $errors,
                "succes" => 'false',
            ], 417);
        }

        $newGame = Game::create($request->all());

        return response()->json([
            "message" => "Game created",
            "succes" => 'true',
        ], 201);
    }

    public function updateGame(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'developer' => 'required|string|max:64',
            'publisher' => 'required|string|max:64'
        ]);

        $errors = $validation->errors();

        if ($validation->fails()) {
            return response()->json([
                "message" => $errors,
                "success" => 'false',
            ], 417);
        }

        if (Game::where('id', $request->id)->exists()) {
            $game = Game::find($request->id);

            $game->name = empty($request->name) ? $game->name : $request->name;
            $game->developer = empty($request->developer) ? $game->developer : $request->developer;
            $game->publisher = empty($request->publisher) ? $game->publisher : $request->publisher;
            $game->save();

            return response()->json([
                "message" => "Game updated successfully",
                "succes" => 'true',
            ], 200);
        } else {
            return response()->json([
                "message" => "Game not found",
                "succes" => 'false',
            ], 404);
        }
    }

    public function deleteGame($id) {
        if(Game::where('id', $id)->exists()) {
            $game = Game::find($id);
            $game->delete();

            return response()->json([
                "message" => "Game deleted",
                "succes" => 'true',
            ], 202);
        } else {
            return response()->json([
                "message" => "Game not found",
                "succes" => 'false',
            ], 404);
        }
    }
}
