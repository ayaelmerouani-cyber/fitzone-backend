<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Reservation; // خاصك تكريه (php artisan make:model Reservation -m)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursController extends Controller
{
    // عرض كاع الحصص
    public function index()
    {
        return Cours::all();
    }

    // منطق الحجز
    public function reserve(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);

        // 1. واش باقة بلاصة؟ (القدرة الاستيعابية)
        $currentReservations = Reservation::where('cours_id', $id)->count();
        if ($currentReservations >= $cours->capacity) {
            return response()->json(['message' => 'Cours complet !'], 400);
        }

        // 2. واش ديجا حاجز هاد الحصة؟
        $alreadyReserved = Reservation::where('user_id', Auth::id())->where('cours_id', $id)->exists();
        if ($alreadyReserved) {
            return response()->json(['message' => 'Vous avez déjà réservé ce cours.'], 400);
        }

        // 3. دير الحجز (إلا ماكانش)
        Reservation::create([
            'user_id' => Auth::id(), // كنعرفو شكون هو المنخرط من الـ Token
            'cours_id' => $id
        ]);

        return response()->json(['message' => 'Réservé avec succès !'], 201);
    }
}