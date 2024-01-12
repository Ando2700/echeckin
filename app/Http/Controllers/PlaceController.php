<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::with('images')->get();
        return view('admin.place.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomplace' => 'required|string|max:255',
                'numberplace' => 'required|integer|min:0',
                'description' => 'required|string',
                'price' => 'numeric|min:0',
                'address' => 'string',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
            ], [
                'price.numeric' => 'Le champ "Prix du lieu" doit être un nombre.',
            ]);

            $nomplace = strtolower($request->input('nomplace'));

            $existingPlace = DB::table('places')->where(DB::raw('LOWER(nomplace)'), strtolower($nomplace))->first();
            if ($existingPlace) {
                Session::flash('error', 'Ce lieu existe déjà dans la list des lieux');
                return redirect()->back()->withInput($request->input());
            }

            $place = Place::create([
                'nomplace' => ucfirst($nomplace),
                'numberplace' => $request->numberplace,
                'price' => $request->price,
                'description' => $request->description,
                'address' => $request->address,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('images', $fileName, 'public');
                    Image::create([
                        'path' => $path,
                        'place_id' => $place->id,
                    ]);
                }
            }

            Session::flash('success', 'Sauvegarde du lieu d\'événement réussie');
            return redirect()->route('places.index');
        } catch (QueryException $e) {
            Session::flash('error', 'Erreur lors de l\'enregistrement du lieu d\'événement : ' . $e->getMessage());
        } catch (\Exception $e) {
            Session::flash('error', 'Une erreur inattendue s\'est produite : ' . $e->getMessage());
        } finally {
            return redirect()->back()->withInput($request->input());
        }
    }


    /**
     * Display a list
     */
    public function list(Request $request)
    {
        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $address = $request->input('address');

        $placesQuery = Place::with('images');

        if ($search) {
            $placesQuery->where('nomplace', 'ilike', '%' . $search . '%');
        }

        if ($address) {
            $placesQuery->where('address', 'ilike', '%' . $address . '%');
        }

        if ($minPrice) {
            $placesQuery->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $placesQuery->where('price', '<=', $maxPrice);
        }

        $places = $placesQuery->paginate(3);

        return view('admin.place.list', compact('places'));
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $place = Place::with('images')->findOrFail($id);
        return view('admin.place.show', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $place = Place::findOrFail($id);
        return view('admin.place.edit', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nomplace' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'numberplace' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
        ]);

        $place = Place::findOrFail($id);
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $image = Image::find($imageId);

                Storage::delete('public/' . $image->path);
                $image->delete();
            }
        }

        $place->nomplace = $request->nomplace;
        $place->address = $request->address;
        $place->numberplace = $request->numberplace;
        $place->description = $request->description;
        $place->price = $request->price;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('images', $fileName, 'public');
                Image::create([
                    'path' => $path,
                    'place_id' => $place->id,
                ]);
            }
        }

        $place->save();

        Session::flash('success', 'Modification du lieu avec succès');
        return redirect()->route('places.list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $place = Place::findOrFail($id);
        foreach ($place->images as $image) {
            $imagePath = 'public/' . $image->path;

            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
            $image->delete();
        }
        $place->delete();

        Session::flash('success', 'Suppression du lieu avec succès');
        return redirect()->route('places.list');
    }
}
