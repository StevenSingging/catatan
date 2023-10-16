<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user  = Auth::user();

        // Periksa peran pengguna dan ambil catatan sesuai peran
        if ($user->role == "admin") {
            $notes = Note::paginate(10);
        } elseif ($user->role == "biasa" || $user->role == "editor") {
            $notes = Note::where('user_id', $user->id)->paginate(10);
        }

        return response()->json(['data' => $notes]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user  = Auth::user();
        // $user = User::find($user_id);
        $note = Note::create([
            'user_id' => $user->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);
        return response()->json([
            'data' => $note
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return response()->json([
            'data' => $note
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $this->validate($request, [
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $note->judul = $request->judul;
        $note->deskripsi = $request->deskripsi;
        $note->save();

        return response()->json([
            'data' => $note
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json([
            'message' => 'Note Deleted'
        ], 204);
    }
}
