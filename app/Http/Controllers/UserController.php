<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use phpoffice\PhpSpreadsheet\Spreadsheet;
use phpoffice\PhpSpreadsheet\writer\Xlsx;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index()
    {
        // Logic to retrieve and display users
        $users = User::paginate(5);
        $total_users = $users->count();
        return view('users.index', compact(['users', 'total_users']));
    }

    public function adminAddUser(Request $request){
        $password = 12345678;
        $addUser = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phonenumber' => $request->phonenumber,
            'role' => $request->role,
            'address' => $request->address,
            'password' => Hash::make($password),
    ]);
        if($addUser){
            alert()->success('Success','Data has been added successfully.');

            return redirect()->back();
        }else{
            alert()->error('Error','Failed to add data.');

            return redirect()->back();
        }
    }

    public function adminUpdateUser(Request $request){

        $updateUser = User::where('id',$request->id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phonenumber' => $request->phonenumber,
            'role' => $request->role,
            'address' => $request->address,
        ]);
            if($updateUser){
                alert()->success('Success','Data has been updated successfully.');
                return redirect()->back();
            }else{
                alert()->error('Error','Failed to update data.');
                return redirect()->back();
            }
        }

    public function adminDeleteUser(Request $request){
        $deleteUser = User::where('id',$request->id)->delete();
        if($deleteUser){
            alert()->success('Success','Data has been deleted successfully.');
            return redirect()->back();
        }else{
            alert()->error('Error','Failed to delete data.');
            return redirect()->back();
        }
}    
  
    public function downloadFile($filename)
    {
        $filePath = public_path('download/Administrators_Data.xlsx');
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            alert()->error('Error', 'File not found.');
            return redirect()->back();
        }
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (count($rows) > 1) {
            foreach ($rows as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                // Adjust indexes based on your Excel columns
                $firstname = $row[0] ?? null;
                $lastname = $row[1] ?? null;
                 $phonenumber = $row[2] ?? null;
                $email = $row[3] ?? null;
                $address = $row[4] ?? null;
                $role = $row[5] ?? null;
                

                // Only insert if required fields are present
                if ($firstname && $lastname && $email) {
                    User::create([
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'email' => $email,
                        'phonenumber' => $phonenumber,
                        'role' => $role,
                        'address' => $address,
                    ]);
                }
            }
            alert()->success('Success', 'Users imported successfully.');
        } else {
            alert()->error('Error', 'No data found in file.');
        }
        return redirect()->back();
    }

    public function customerRegistration(){
        return view('users.customerRegistration');
    }
}