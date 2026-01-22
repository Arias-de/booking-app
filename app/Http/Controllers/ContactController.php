<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactRequest;

class ContactController extends Controller
{
    /**
     * Enregistrer une demande depuis la landing page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company'   => 'required|string|max:255',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:20',
            'need_type' => 'required|string|max:255',
            'message'   => 'required|string|max:2000',
        ]);

        ContactRequest::create($validated);

        return redirect()->back()->with(
            'success',
            'Merci ! Votre demande a bien été reçue. Nous vous recontacterons sous 48h.'
        );
    }

    /**
     * Afficher les demandes dans le dashboard admin
     */
    public function index()
    {
        $requests = ContactRequest::latest()->paginate(10);
        $unreadCount = ContactRequest::where('is_read', false)->count();

        return view('admin.contact-requests', compact('requests', 'unreadCount'));
    }

    /**
     * Marquer une demande comme lue
     */
    public function markAsRead($id)
    {
        $request = ContactRequest::findOrFail($id);
        $request->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Demande marquée comme lue.');
    }

    /**
     * Supprimer une demande
     */
    public function destroy($id)
    {
        ContactRequest::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Demande supprimée avec succès.');
    }
}
