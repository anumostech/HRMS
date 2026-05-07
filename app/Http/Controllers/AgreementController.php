<?php

namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Party;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AgreementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);

        $agreements = Document::with('shareWith')->where('type', 'agreement')->latest()->get();
        $parties = Party::select('id', 'name')->get();
        $share_with = User::select('id', 'name')->get();

        $folders = Document::select('folder')
            ->distinct()
            ->pluck('folder');

        return view('documents.agreements', compact('agreements', 'folders', 'parties', 'share_with'));
    }
    public function show($id)
    {
        $agreement = Document::findOrFail($id);
        
        if ($agreement->expiry_date) {
            $agreement->expiry_date = Carbon::parse($agreement->expiry_date)->format('d-m-Y');
        }
        
        return response()->json($agreement);
    }

    public function update(Request $request, $id)
    {
        $agreement = Document::findOrFail($id);
        
        $agreement->update([
            'name' => $request->name,
            'description' => $request->description,
            'folder' => $request->folder,
            'party_id' => $request->party_id,
            'share_with' => $request->share_with,
            'expiry_date' => $request->expiry_date
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $agreement = Document::findOrFail($id);
        
        // Optionally delete the file from storage
        if (Storage::disk('public')->exists($agreement->file_path)) {
            // Storage::disk('public')->delete($agreement->file_path);
        }
        
        $agreement->delete();

        return response()->json(['success' => true]);
    }
}
