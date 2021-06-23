<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Annonce; // Model
use Illuminate\Support\Facades\DB; // DB


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' =>['index','article','search']]);
    }
    //index :
    public function index() {
        // Récupération des annoncex via le Model Article
        $annonces = Annonce::all();
        
        //Récupération annonce d'un user
        $annonceUser = DB::table('annonces')
        ->join('users', 'annonces.user_id', '=', 'users.id')
        ->select('annonces.*', 'users.email')
        ->get();

        //dd($annonceUser);
        
        // affiche la liste des annoncex
        return view('article', compact('annonces', 'annonceUser')); // dbname
        
    }

    public function create() {
        // create submit les data à store() avec son form
        return view('create');
    }

    public function store(Request $request) {
        // condition d'input corrects :
            $request->validate([
                'name'=>'required|unique:annonces',
                'description'=>'required',
                'price' => 'required|min:1',
                'photo'=>'required|image|mimes:jpeg,png,gif,jpg|max:2048',
            ]);
            
                // Si la requête prend une photo
                if($request->hasFile('photo')) {
                    $photo = $request->file('photo');
                    $name = $photo->getClientOriginalName();
                    // chemin d'images :
                    $request->photo->move(public_path('images'), $name);
                    //dd($name);

                // puis insertion bdd
                $query = DB::table('annonces')->insert([
                    'name'=>$request->input('name'),
                    'description'=>$request->input('description'),
                    'price'=>$request->input('price'),
                    'photo'=>$request=$name,

                ]);
                
                }

            return redirect('article')->with('success', 'L\'annonce a bien été enregistrée.');
    }


    public function edit($id) {
        $data_id = Annonce::findOrFail($id);
        // affiche le form pour éditer l'annonce
        //dd($data_id);
        return view('edit', compact('data_id'));
    }

    public function show($id) {
        $data = Annonce::find($id);
        return view('edit', ['data' => $data]);
    }

    public function update(Request $request) {

    $data=Annonce::find($request->id);

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price' => 'required',
            'photo'=>'required',
        ]);

            if($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = $photo->getClientOriginalName();
                // chemin d'images :
                $request->photo->move(public_path('images'), $filename);
                //dd($filename);

            $data->name=$request->name;
            $data->description=$request->description;
            $data->price=$request->price;
            $data->photo=$filename;

            } 
            
        $data->save();
        

        return redirect('article')->with('success', 'L\'annonce a bien été modifiée.');
    }

    public function search() {
        // $search = $request->get('search');
        // $annonces = DB::table('annonces')->where('name', 'LIKE', '%'.$search.'%')->paginate(10);
        return view('search'); 
    }


    public function destroy($id) {
        $request = Annonce::findOrFail($id);
        $request->delete();

        return redirect('article')->with('success', 'L\'annonce a bien été effacée.');
    }

}  