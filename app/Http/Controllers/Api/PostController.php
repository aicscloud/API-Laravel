<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(Request $request)
    {
        try{
            $query = Post::query();
            $perPage = 5;
            $page= $request->input('page', 1);
            $search = $request->input('search');
            if($search){
                $query->whereRaw("title LIKE '%".$search."%'");
            }
            $total = $query->count();
            $resultat = $query->offset(($page - 1)* $perPage)->limit($perPage)->get();

            return response()->json([
             "succes"=>true,
             "message"=>'Liste de poste!',
             "current_page"=>$page,
             "last_page"=>ceil($total/$perPage),
             "items"=>$resultat
            ]);
          }catch(Exception $e){
            return response()->json($e);
          };
    }


    public function store(StorePostRequest $request)
    {
      try{
        $post = new Post();
        $post->title=$request->title;
        $post->content=$request->content;
        $post->user_id = auth()->user()->id;
        $post->save();
        return response()->json([
         "succes"=>true,
         "message"=>'Votre poste été crée avec success !',
         "data"=>$post
        ]);
      }catch(Exception $e){
        return response()->json($e);
      }
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        try{
            $post->title = $request->title;
            $post->content = $request->content;
            if($post->user_id == auth()->user()->id){
            $post->save();
            return response()->json([
                "succes"=>true,
                "mesage"=>"Votre poste a été mise à jour!",
                "data"=>$post
            ]);
        }else{
            return response()->json([
                "succes"=>false,
                "mesage"=>"Ce post ne vous appartient pour le modifier!",
                "data"=>$post
            ]);
        }
        }catch(Exception $e){
            return response()->json($e);
        };
    }

    public function destroy(Post $post)
    {
        try{
            if($post->user_id === auth()->user()->id){
            $post->delete();
            return response()->json([
                "succes"=>true,
                "mesage"=>"Votre poste a été supprimé !"
            ]);
        }else{
            return response()->json([
                "succes"=>false,
                "mesage"=>"Ce poste ne vous appartient pour le supprimer!"
            ]);
            };
        }catch(Exception $e){
            return response()->json($e);
        };
    }
}
