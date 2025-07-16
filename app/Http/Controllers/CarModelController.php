<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarModel;
use RealRashid\SweetAlert\Facades\Alert;

class CarModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // List all car models
    public function index(Request $request)
    {
        $carModels = CarModel::paginate(5);
        $total_models = $carModels->count();
        $selectedModel = null;
        if ($request->has('model')) {
            $selectedModel = CarModel::with('cars')->find($request->model);
        }
        return view('car_models.index', compact('carModels', 'total_models', 'selectedModel'));
    }

    // Show form to create a new car model
    public function create()
    {
        return view('car_models.create');
    }

    // Store a new car model
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:car_models,name',
        ]);

        $carModel = CarModel::create([
            'name' => $request->name,
        ]);

        if ($carModel) {
            Alert::success('Success', 'Car model added successfully.');
        } else {
            Alert::error('Error', 'Failed to add car model.');
        }
        return redirect()->route('car-models.index');
    }

    // Show form to edit a car model
    public function edit($id)
    {
        $carModel = CarModel::findOrFail($id);
        return view('car_models.edit', compact('carModel'));
    }

    // Update a car model
    public function update(Request $request, $id)
    {
        $carModel = CarModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:car_models,name,' . $carModel->id,
        ]);

        $carModel->update([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Car model updated successfully.');
        return redirect()->route('car-models.index');
    }

    // Delete a car model
    public function destroy($id)
    {
        $carModel = CarModel::findOrFail($id);
        $carModel->delete();

        Alert::success('Success', 'Car model deleted successfully.');
        return redirect()->route('car-models.index');
    }
}
