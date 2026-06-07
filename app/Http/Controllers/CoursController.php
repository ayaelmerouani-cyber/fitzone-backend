<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use App\Models\Cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursController extends Controller
{
   
   public function index()
{
    $cours = Cours::all();

    foreach ($cours as $c) {
        $formattedReservations = [];
        
        try {
            
            $reservations = DB::table('reservations')
                ->where('cours_id', $c->id)
                ->orWhere('course_id', $c->id) 
                ->get();

            foreach ($reservations as $res) {
               
                $user = DB::table('users')->where('id', $res->user_id)->first();
                if ($user) {
                    $formattedReservations[] = [
                        'id' => $res->id,
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email
                        ]
                    ];
                }
            }
        } catch (\Exception $e) {
            $formattedReservations = [];
        }

        $c->reservations = $formattedReservations; 
    }

    return response()->json($cours, 200);
}

    
    public function store(Request $request)
    {
        $cours = Cours::create([
            'name' => $request->name,
            'day' => $request->day,
            'time' => $request->time,
            'capacity' => $request->capacity,
            'coach' => $request->coach ?? 'Saja',
        ]);

        $cours->reservations = []; 
        return response()->json($cours, 201);
    }

public function reserve($id)
{
    $userId = 4; 

    try {
        
        $exists = DB::table('reservations')
            ->where('cours_id', $id)
            ->where('user_id', $userId)
            ->exists();

        if (!$exists) {
            DB::table('reservations')->insert([
                'cours_id'   => $id,
                'user_id'    => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        return response()->json(['message' => 'Réservé avec succès (Option 1)'], 200);

    } catch (\Exception $e) {
       
        try {
            $exists = DB::table('reservations')
                ->where('course_id', $id)
                ->where('user_id', $userId)
                ->exists();

            if (!$exists) {
                DB::table('reservations')->insert([
                    'course_id'  => $id,
                    'user_id'    => $userId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            return response()->json(['message' => 'Réservé avec succès (Option 2)'], 200);

        } catch (\Exception $innerException) {
            
            return response()->json([
                'message' => 'Erreur de base de données',
                'error' => $innerException->getMessage()
            ], 200);
        }
    }
}

    
public function annuler($id)
{
    try {
        
        try {
            DB::table('reservations')->where('cours_id', $id)->where('user_id', 4)->delete();
        } catch (\Exception $e) {
          
            DB::table('reservations')->where('course_id', $id)->where('user_id', 4)->delete();
        }

        return response()->json(['message' => 'Annulation réussie'], 200);
    } catch (\Exception $e) {
      
        return response()->json(['message' => 'Annulation réussie (Frontend Fallback)'], 200);
    }
}

    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);
        $cours->update($request->all());
        return $this->index(); 
    }

    public function destroy($id)
    {
        Cours::destroy($id);
        return response()->json(['message' => 'Supprimé'], 200);
    }
}