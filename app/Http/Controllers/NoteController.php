<?php


namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NoteController
{
    /**
     * affiche en alerte les users et la possibilité de noter
     * @param int $idRide
     * @return \Illuminate\Http\RedirectResponse
     */
    public function noteTrip(int $idRide)
    {
        //TODO temporaire, il faut lier au num du trip
        $users = $users = DB::table('users')->get();


        return Redirect::back()->with('notation_trajet', $users);
    }

    /**
     * form POST notation des users
     * @param Request $request
     * @return RedirectResponse
     */
    public function notation(Request $request)
    {
/*        test*/
        var_dump($request->all());

        return back()->with('success', 'Personnes notées.');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     * page de vue des notes attribuées par membre par trajet
     */
    public function attributedNotes()
    {
        //TODO ajouter les membres notés par l'utilisateur par trajet
        return view('user.notes.attributedNotes');
    }
}
