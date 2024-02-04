<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ViewController extends DataController
{

    public function defaultView($data){
        $script =array (
            config("site-specific.jquery-js"),
            config("site-specific.datatable-js"),
            config("site-specific.sweetalert-js"),
        );

        $css=array (
            config("site-specific.datatables-css"),
            config("site-specific.tailwind-css"),      
        );

        if(isset($data["script"])){
            $data['script'] = array_merge($script, $data["script"]);
        }else{
            $data["script"] = $script;
        }
        if(isset($data["css"])){
            $data["css"] = array_merge($css, $data["css"]);
        }
        else{
            $data["css"] = $css;
        }
        return View::make('admin.home', $data);
    }

    public function dashboard(){
        $authuser=$this->getAuthUser();
        if($authuser->usertype== 0){
            $body='dashboard';
        }else if($authuser->usertype== 1 || $authuser->usertype== 2){
            $body= 'admin.dashboard';
        }
        $data=array(
            'body'=> $body,
            'navbar'=>'navigation-menu',
            'script'=> array(config("site-specific.custom-dashboard-js"), ),
            'users'=>$this->getUsers(),

            
        );
        return $this->defaultView($data);


    }
}
