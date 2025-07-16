<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use phpoffice\PhpSpreadsheet\Spreadsheet;
use phpoffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\CarModel;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $cars = Car::with('carModel')->paginate(4);
        $total_cars = $cars->total();
        $car_models = CarModel::all();
        return view('cars.index', compact('cars', 'total_cars', 'car_models'));
    }

    public function adminAddCar(Request $request)
    {
        // $request->validate([
        //     // 'make' => 'required',
        //     // 'model' => 'required',
        //     // 'registration_number' => 'required|unique:cars',
        //     // 'year' => 'required|integer',
        //     // 'color' => 'required',
        //     // 'rate_per_day' => 'required|numeric',
        //     // 'rate_per_km' => 'required|numeric',
        //     // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     // 'car_model_id' => 'required|exists:car_models,id',
        // ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        $addCar = Car::create([
            'make' => $request->make,
            'car_model_id' => $request->car_model_id,
            // 'model' => $request->model,
            'registration_number' => $request->registration_number,
            'year' => $request->year,
            'color' => $request->color,
            'rate_per_day' => $request->rate_per_day,
            'rate_per_km' => $request->rate_per_km,
            'image' => $imageName,
            
        ]);

        if ($addCar) {
            alert()->success('Success', 'Car has been added successfully.');
            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to add car.');
            return redirect()->back();
        }
    }

    public function adminUpdateCar(Request $request)
    {
        $car = Car::findOrFail($request->id);

        // $request->validate([
        //     'make' => 'required',
        //     'model' => 'required',
        //     'registration_number' => 'required|unique:cars,registration_number,' . $car->id,
        //     'year' => 'required|integer',
        //     'color' => 'required',
        //     'rate_per_day' => 'required|numeric',
        //     'rate_per_km' => 'required|numeric',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        $updateCar = $car->update([
            'make' => $request->make,
            'model' => $request->model,
            'registration_number' => $request->registration_number,
            'year' => $request->year,
            'color' => $request->color,
            'rate_per_day' => $request->rate_per_day,
            'rate_per_km' => $request->rate_per_km,
            'image' => $car->image,
        ]);

        if ($updateCar) {
            alert()->success('Success', 'Car has been updated successfully.');
            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to update car.');
            return redirect()->back();
        }
    }

    public function adminDeleteCar(Request $request)
    {
        $car = Car::findOrFail($request->id);
        $deleteCar = $car->delete();

        if ($deleteCar) {
            alert()->success('Success', 'Car has been deleted successfully.');
            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to delete car.');
            return redirect()->back();
        }
    }

    public function welcome()
    {
        $carModels= CarModel::all();
        $cars = Car::with('carModel')->get();
        return view('welcome', compact('cars', 'carModels'));
    }

    public function searchCar(Request $request){
        $carModels= CarModel::all();
        $cars = Car::with('carModel')->where('car_model_id', $request->car_model_id)->get();
        return view('cars.filteredCars', compact('cars', 'carModels'));
    }

    // public function carDetails(Request $request){
    //     $carModels= CarModel::all();
    //     $car = Car::with('carModel')->where('id', $request->car_id)->first();
    //     return view('cars.carDetails', compact('car','carModels',));
    // }

    public function carDetailsPerDay(Request $request){
        $carModels= CarModel::all();
        $car = Car::with('carModel')->where('id', $request->car_id)->first();
        return view('cars.carDetailsPerDay', compact('car','carModels',));
    }

    public function carDetailsPerKm(Request $request){
        $carModels= CarModel::all();
        $car = Car::with('carModel')->where('id', $request->car_id)->first();
        return view('cars.carDetailsPerKm', compact('car','carModels',));
    }
    
}