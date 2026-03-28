<?php

namespace App\Http\Controllers;
use App\Models\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);

        $agreements = Document::where('type','agreement')->latest()->get();
        $folders = Document::select('folder')
            ->distinct()
            ->pluck('folder');

        return view('documents.agreements', compact('agreements', 'folders'));
    }
    
}
