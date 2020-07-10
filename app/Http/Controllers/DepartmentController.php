<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Exception;


class DepartmentController extends Controller
{

    /**
     * using auth middleware for any function 
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['success']    = true;
        $data['deparments'] = Department::all(['id','name']);
        return response()->json($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        try{
            $request->validate(['name' => 'required|unique:departments']);
            $department       = new Department();
            $department->name = $request->name;
            $department->save();
            
            $data['success'] = true;
            $data['message'] = 'department '.$department->name.' stored successfuly with id = '.$department->id;
            return response()->json($data);

        }catch(\Exception $e) {
                
            $data['success'] = false;
            $data['message'] = 'error while storing department '.$request->name;
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            
            $data['success']    = true;
            $data['department'] = Department::where(['id' => $id])->first(['id','name']);
            if($data['department'] == null)throw new Exception();
            return response()->json($data);

        }catch(Exception $e){
            $data['success'] = false;           
            $data['message'] = 'Department id not matched  '.$e->getMessage();
            return response()->json($data); 
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        try{
            $request->validate(['name' => 'required|unique:departments']);
            $update=['name' => $request->name];
            Department::where(['id'=>$id])->update($update);
            $data['success']  = true;
            $data['message']  = 'Department with id = '.$id.' updated successfuly to '.$request->name;
            return response()->json($data);

        }catch(Exception $e){
            $data['success'] = false;           
            $data['message'] = 'Department with id = '.$id.' not updated '.$e->getMessage();
            return response()->json($data);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            // throw new Exception if Department not exist
            if(!Department::where(['id'=>$id])->delete())throw new Exception();
            $data['success']  = true;
            $data['message']  = 'Department with id = '.$id.' successfuly deleted';
            return response()->json($data);
        }catch(Exception $e){
            $data['success'] = false;           
            $data['message'] = 'Department with id = '.$id.' not deleted '.$e->getMessage();
            return response()->json($data);
        }
    }
}
