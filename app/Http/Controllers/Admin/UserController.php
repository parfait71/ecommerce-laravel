<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Empêcher l'admin de se supprimer lui-même
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier votre propre compte depuis cette interface.');
        }

        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'is_admin' => 'required|boolean',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.min' => 'Le nom doit contenir au moins 2 caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'is_admin.required' => 'Le rôle est obligatoire.',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => $request->is_admin,
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur "' . $user->name . '" mis à jour avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $user)
    {
        // Empêcher l'admin de se supprimer lui-même
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', '❌ Vous ne pouvez pas supprimer votre propre compte. Contactez un autre administrateur.');
        }

        // Empêcher la suppression du dernier admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', '❌ Impossible de supprimer le dernier administrateur. Créez d\'abord un autre admin.');
        }

        try {
            // Vérifier si l'utilisateur a des commandes
            $orderCount = $user->orders()->count();
            
            $userName = $user->name;
            $userEmail = $user->email;
            
            // Supprimer l'utilisateur
            $user->delete();

            $message = "✅ Utilisateur supprimé avec succès !\n\n";
            $message .= "Nom : {$userName}\n";
            $message .= "Email : {$userEmail}\n";
            
            if ($orderCount > 0) {
                $message .= "⚠️ {$orderCount} commande(s) associée(s) ont également été supprimée(s).";
            }

            return redirect()->route('admin.users.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression d\'utilisateur', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.users.index')
                ->with('error', '❌ Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    // Export PDF des utilisateurs
    public function exportPdf()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('admin.users.pdf', compact('users'));
        
        return $pdf->download('utilisateurs-eazystore-' . date('Y-m-d') . '.pdf');
    }

    // Export Excel des utilisateurs
    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'utilisateurs-eazystore-' . date('Y-m-d') . '.xlsx');
    }
}
