<?php

namespace App\Http\Controllers\SERVER;

use App\Model\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class NoteWebController extends Controller
{
    public function all(Request $request)
    {
        $this->validate($request, ['enterprise' => 'required']);
        $notes = Note::where('enterprise', \request('enterprise'))
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('recipient', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy('date', 'ASC')->paginate(5);
        return ['count' => count($notes), 'html' => View::make('note.list_notes')->with('notes', $notes)->render()];
    }
}
