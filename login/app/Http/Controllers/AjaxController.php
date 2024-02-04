<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class AjaxController extends Controller
{
    public function getAllUsers(Request $request){
        $query = User::paginate($request->input('length'));


        foreach ($query as $key => $value) {
            if($value->usertype == 0){
                $query[$key]->usertype_lable = "Guest";
            }
            elseif($value->usertype == 1){
                $query[$key]->usertype_lable = "Admin";
            }
            elseif($value->usertype == 2){
                $query[$key]->usertype_lable = "SuperAdmin";
            }
            $query[$key]->edit_button = "<button class='bg-yellow-500 text-white px-4 py-2 rounded-md edit-btn' data-id='{$value->id}' data-name='{$value->name}' data-username='{$value->username}' data-email='{$value->email}' onclick='openEditablePopup(this)'>Preview</button>";


            if($value->is_active == 0){
            $query[$key]->is_active_button = "<button class='bg-green-500 text-white px-4 py-2 rounded-md action-btn'data-user-id='{{ $value->id }}' onclick='statusChanger($value->id,1)'>
            Activate
        </button>";
            }elseif($value->is_active == 1){
                $query[$key]->is_active_button = "<button class='bg-red-500 text-white px-4 py-2 rounded-md action-btn'data-user-id='{{ $value->id }}'onclick='statusChanger($value->id,0)'>
            Deactivate
        </button>";
            }

        }
        




        $paginated_list = json_decode(json_encode($query));
        $query = $query->map(function ($query) {

        return $query;
        })->all();

        $response['draw']=$request->draw;
        $response['recordsFiltered'] = $paginated_list->total;
        $response['recordsTotal'] = $paginated_list->total;
        $response['data'] = $query;
        return response()->json($response);
    }

    public function statusChanger(Request $request){
        try {
            $user=User::find($request->id);
            $user->is_active = $request->action;
            $user->save();
            return response()->json(['status'=> 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status'=> 'error']);
            
        }

    }

    public function updateUser(Request $request) {
        try {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();
    
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }
}
