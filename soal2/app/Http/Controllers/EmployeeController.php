<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::all();
        return view('employee_index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|varchar|max:15',
            'nama' => 'required|varchar|max:150',
            'jabatan' => 'required|varchar|max:200',
            'talahir' => 'required|date',
            'photo_upload_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048'
        ]);

        #upload photo
        if ($request->hasFile('photo_upload_path')) {
            $path = $request->file('photo_upload_path')->store('photos', 's3');
            $url = Storage::disk('s3')->url($path);
            $data['photo_upload_path'] = $url;
        }

        $data['created_on'] = now();

        Employee::create($request->all());
        return redirect('/employee')->with('success', 'Data pegawai berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor' => 'required|varchar|max:15',
            'nama' => 'required|varchar|max:150',
            'jabatan' => 'required|varchar|max:200',
            'talahir' => 'required|date',
            'photo_upload_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1048'
        ]);

        if ($request->hasFile('photo_upload_path')) {
            $path = $request->file('photo_upload_path')->store('photos', 's3');
            $url = Storage::disk('s3')->url($path);
            $data['photo_upload_path'] = $url;
        }

        $data['updated_on'] = now();

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect('/employee')->with('success', 'Data pegawai berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect('/employee')->with('success', 'Data pegawai berhasil dihapus');
    }
}
