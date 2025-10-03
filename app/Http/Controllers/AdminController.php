<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
    public function admin()
    {
        $admins = Admin::with('user')->paginate(10); // or use get() for all
        $total_admins = Admin::count();
        return view('admins.admin', compact('admins', 'total_admins'));
    }

    public function adminAddAdmin(Request $request)
    {
        Log::info('AdminAddAdmin method called with data:', $request->all());
        
        $password = 12345678;
        
        try {
            // Create user first
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
                'role' => 'Admin',
                'address' => $request->address,
                'password' => Hash::make($password),
            ]);
            
            if($user){
                // Create admin record linked to user
                $admin = Admin::create([
                    'user_id' => $user->id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'phonenumber' => $request->phonenumber,
                    'role' => 'Admin',
                    'address' => $request->address,
                    'password' => Hash::make($password),
                ]);
                
                if($admin){
                    Log::info('Admin created successfully');
                    alert()->success('Success','Admin has been added successfully.');
                } else {
                    Log::error('Failed to create admin record');
                    alert()->error('Error','Failed to create admin record.');
                }
            } else {
                Log::error('Failed to create user record');
                alert()->error('Error','Failed to create user record.');
            }
        } catch (\Exception $e) {
            Log::error('Error in adminAddAdmin: ' . $e->getMessage());
            alert()->error('Error', 'An error occurred: ' . $e->getMessage());
        }
        
        return redirect()->back();
    }

    public function adminUpdateAdmin(Request $request)
    {
        $admin = Admin::find($request->id);
        
        if($admin && $admin->user) {
            // Update user record
            $admin->user->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
                'address' => $request->address,
            ]);
            
            // Update admin record
            $admin->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
                'address' => $request->address,
            ]);
            
            alert()->success('Success', 'Admin has been updated successfully.');
        } else {
            alert()->error('Error', 'Admin not found.');
        }
        
        return redirect()->back();
    }

    public function adminDeleteAdmin(Request $request)
    {
        $admin = Admin::find($request->id);
        
        if($admin) {
            if($admin->user) {
                $admin->user->delete(); // This will also delete the admin due to cascade
            }
            alert()->success('Success', 'Admin has been deleted successfully.');
        } else {
            alert()->error('Error', 'Admin not found.');
        }
        
        return redirect()->back();
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
        $spreadsheet = IOFactory::load($file->getPathname());
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

}
