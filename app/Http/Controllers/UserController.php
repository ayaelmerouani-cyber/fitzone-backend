<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // هادي كتجيب كاع المستخدمين
        return response()->json(User::all(), 200);
    }

    // هاد الدالة الجديدة هي لي كتمسح المنخرط
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Adhérent supprimé avec succès']);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'abonnement' => $request->abonnement,
            'statut' => $request->statut,
            'certificat' => $request->certificat
        ]);
        
        return response()->json(['message' => 'Adhérent mis à jour avec succès', 'user' => $user]);
    }
}