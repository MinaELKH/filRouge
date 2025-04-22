<?php

namespace App\Repositories;

use App\Models\Service;
use App\Models\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface

{
  public function create(array $user){
      // dans query builder apres l inseration on return true ou false a l invers de eloquant
      // la methode   $user = User::create($userData);  qui recupere l user des le debut
      $userId = DB::table('users')->insertGetId($user);
      // Récupérer l'utilisateur en tant qu'objet User
      return $this->findById($userId);
  }
  public function update( array $user , $id,){
      DB::table('users')->where('id' , '=' , $id)->update($user);
      return response()->json(['message'=>'user modifie avec succes'], 201) ;
  }
  public function delete($id){
      DB::table('users')->where('id' , '=' , $id)->delete();
      return response()->json(['message'=>'user supprime avec succes'], 201);
  }
  public function findById($id){
      return User::find($id);

  }
  public function findByEmail($email){
     return   $user = DB::table('users')->where('email' , '=' , $email)->first();
  }
  public function findByRole($role){
      $user = DB::table('users')->where('role' , '=' , $role)->first();

  }


    public function getUser($user_id)
    {
        return User::find($user_id);
    }

    public function banir($user_id)
    {
        $user = $this->findById($user_id);
        $user->is_banned = !$user->is_banned; // Inverse le statut du bannissement
        $user->save();

        return $user;
    }

    public function getUsers($search, $role)
    {
        return User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            // ici on ne filtre plus par "banned", on les prend tous
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function countByRole(string $role): int
    {
        return User::where('role', $role)->count();
    }
    public function getTopPrestataires(int $limit)
    {
        return User::where('role', 'prestataire')
            ->select('id', 'name')  // Si vous ne souhaitez récupérer que certains champs
            ->withCount('services')
            ->orderByDesc('services_count')
            ->take($limit)
            ->get();
    }
    public function getTopCategories(int $limit)
    {
        return Service::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->take($limit)
            ->get();
    }

    public function getTopServices(int $limit)
    {
        return Service::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take($limit)
            ->get();
    }

}
