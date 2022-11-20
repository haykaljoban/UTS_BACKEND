<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Dotenv\Store\File\Paths;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class PatientController extends Controller
{
  # Get all resource patients
  public function index()
  {
    # Get all data using eloquent method all()
    $patients = Patient::all();
    # if patients doesn't have any data (empty)
    if ($patients->count() == 0) {
      $errorMessage = [
        'message' => 'Data patient is empty'
      ];
      # return data (json) with 404 status code
      return response()->json($errorMessage, 404);

      # if there are data returned
    } else {
      $data = [
        'message' => 'Get all patients',
        'data' => $patients,
      ];
      # return data (json) with 200 status code
      return response()->json($data, 200);
    }
  }


  # Get specific patients with id
  public function show($id)
  {
    # Get specific data with id using eloquent method find()
    $data = Patient::find($id);
    # if the id is not a number
    if (!is_numeric($id)) {
      $errorMessage = [
        'message' => "id you entered '$id' is not a number"
      ];
      # return data (json) with 404 status code
      return response()->json($errorMessage, 404);

      # if there is no data with id entered
    } else if ($data == null) {
      $errorMessage = [
        'message' => "data with id $id doesn't exist"
      ];
      # return data (json) with 404 status code
      return response()->json($errorMessage, 404);
    }
    # return data (json) with 200 status code
    return response()->json($data, 200);
  }


  # Search patients by name
  public function search($name)
  {
    # Get specific data with wildcard using eloquent method where()
    $data = Patient::where('name', 'LIKE', "%$name%")->get();
    if($data->count() == 0) {
      $errorMessage = [
        'message' => "data with name like '$name' doesn't exist"
      ];
      # return data (json) with 404 status code
      return response()->json($errorMessage, 404);
    } else {
      # return data (json) with 200 status code 
      return response()->json($data, 200);
    }
  }


  # Get patients with positive status
  public function positive()
  {
    # Get specific data with wildcard using eloquent method where()
    $patients = Patient::where('status', 'positive')->get();

    #If there is no data found
    if ($patients->count() == 0) {
      $errorMessage = [
        "message" => "Alhamdulillah, There are no positive covid patients",
      ];
      # return data (json) with 404 status code 
      return response()->json($errorMessage, 404);
    } else {
      # return data (json) with 200 status code
      return response()->json($patients, 200);
    }
  }

  # Get patients with recovered status
  public function recovered()
  {
    # Get specific data with wildcard using eloquent method where()
    $patients = Patient::where('status', 'recovered')->get();

    #If there is no data found
    if ($patients->count() == 0) {
      $errorMessage = [
        "message" => "There are no recovered covid patients, for now",
      ];
      # return data (json) with 404 status code 
      return response()->json($errorMessage, 404);
    } else {
      # return data (json) with 200 status code
      return response()->json($patients, 200);
    }
  }

  # Get patients with dead status
  public function dead()
  {
    # Get specific data with wildcard using eloquent method where()
    $patients = Patient::where('status', 'dead')->get();

    #If there is no data found
    if ($patients->count() == 0) {
      $errorMessage = [
        "message" => "Alhamdulillah, There are no dead covid patients",
      ];
      # return data (json) with 404 status code 
      return response()->json($errorMessage, 404);
    } else {
      # return data (json) with 200 status code
      return response()->json($patients, 200);
    }
  }

  # Add resource patients
  public function store(Request $request)
  {
    # Make data validation
    $dataValidation = $request->validate([
      # column => rule|rule
      'name' => 'required',
      'phone' => 'numeric|required',
      'address' => 'required',
      'status' => 'required',
      'in_date_at' => 'required',
      'out_date_at' => 'required'
    ]);


    # data inserted to patient model using eloquent method create()
    $patient = Patient::create($dataValidation);

    $data = [
      "message" => "Data successfully inserted to patient model",
      "data" => $patient
    ];

    # return data (json) with 201 status code
    return response()->json($data, 201);
  }

  # Edit resource patients
  public function update($id, Request $request)
  {
    $patient = Patient::find($id);
    if ($patient == null) {
      $errorMessage = [
        "message" => "update data failed, data with id $id doesn't exist"
      ];
      # return data (json) with 404 status code
      return response()->json($errorMessage, 404);
    } else {
      # Make data validation
      $dataValidation = $request->validate([
        # column => rule|rule
        'name' => '',
        'phone' => 'numeric',
        'address' => '',
        'status' => '',
        'in_date_at' => '',
        'out_date_at' => ''
      ]);

      # Update data
      $updated = $patient->update($dataValidation);

      $data = [
        "message" => "Patient with id $id has succesfully updated",
        "data" => $patient
      ];

      # return data (json) with 200 status code
      return response()->json($data, 200);
    }
  }


  # Delete resource patients
  public function destroy($id)
  {
    # Get specific data with id using eloquent method find()
    $patient = Patient::find($id);

    # If data patient exist
    if ($patient) {
      $patient->delete();
      $data = [
        "message" => "Patient with id $id has succesfully deleted"
      ];

      # return data (json) with 200 status code
      return response()->json($data, 200);

      # If data with id entered is not found
    } else {
      $data = [
        "message" => "delete data failed, data with id $id doesn't exist"
      ];

      # return data (json) with 404 status code
      return response()->json($data, 404);
    }
  }
}