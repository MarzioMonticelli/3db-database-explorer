<?php

require_once('API.class.php');
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/ApiKey.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/UserLog.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/Object3D.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/DBDatabase.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/DBTable.php");
require_once($_SERVER['DOCUMENT_ROOT']."/3dB/models/DBCol.php");


class ThreedbAPI extends API
{
    protected $User;
    protected $enabled = true;

    public function __construct($request, $apikey, $origin) {
      if(isset($apikey)){
        $APIKey = new APIKey(null ,$apikey);
        if(!$APIKey->isValidKey()){
          throw new Exception("API ERROR - Invalid key");
        }
      }else{
        throw new Exception("API ERROR - You have to specify your apikey to use the service!");
      }
      parent::__construct($request);
    }

    /* ENDPOINTS */

     protected function enabled() {
      if ($this->method == 'GET') {
        if($this->enabled)
            return "Api are enabled";
        else
            return "API are not enabled.";
        } else {
            return "Only accepts GET requests";
        }
     }

     protected function users($info){
       if($this->method == "GET") {
         $case  = $info[0];
         switch($case){
           case "single":
             $user_id = $info[1];
             $u = new User($user_id);
             $u->load();
             $a = $u->toArray();
             $ak = new Apikey($user_id);
             if($ak->load())
              return array_merge($a, $ak->toArray());
             else
              return "[API ERROR] error during key retrieving.";
           break;
           case "all":
             $users = User::getAll();
             $ret = [];
             foreach($users as $user){
               array_push($ret, $user->toArray());
             }
             return $ret;
           break;
           default:
            throw new Exception("API ERROR - Invalid request " . $case);
           break;
         }
       }
     }

     protected function Object3D($info){
       if($this->method == "POST") {
         if(count($info) == 11){
           $ref_id = $info[0];
           $object_id = (int)$info[1];
           $posx = (float)$info[2];
           $posy = (float)$info[3];
           $posz = (float)$info[4];
           $size = (float)$info[5];
           $material = $info[6];
           $opacity = (double)$info[7];
           $texture = $info[8];
           $color = $info[9];
           $type = $info[10];
           $ob = new Object3D($object_id);
           if($ob->load()){
             if($ob->getReferto() == $object_id){
               $ob->setPositionX($posx);
               $ob->setPositionY($posy);
               $ob->setPositionZ($posz);
               $ob->setSize($size);
               $ob->setMaterial($material);
               $ob->setOpacity($opacity);
               $ob->setTexture($texture);
               $ob->setColor($color);
               if($ob->update()){
                 return ["Success"];
               }else{
                 return ["Fail"];
               }
             }else{
               throw new Exception("API ERROR - invalid object ID.");
             }
           }else{
             $ob = Object3D::getObject3DReference($ref_id);
             if($ob instanceof Object3D){
               $ob->setPositionX($posx);
               $ob->setPositionY($posy);
               $ob->setPositionZ($posz);
               $ob->setSize($size);
               $ob->setMaterial($material);
               $ob->setOpacity($opacity);
               $ob->setTexture($texture);
               $ob->setColor($color);
               if($ob->update()){
                 return ["Success"];
               }else{
                 return ["Fail"];
               }
             }else{

               switch($type){
                 case "database":
                   $db = new DBDatabase($ref_id);
                   if($db->load()){
                     $ob = new Object3D(0, $posx, $posy, $posz, $size, $ref_id, $material, $texture,$color, $opacity);
                     if($ob->save())
                       return ["Success"];
                     else
                       return ["Fail"];
                   }else{
                     throw new Exception("API ERROR - Invalid database id passed.");
                   }
                 break;
                 case "table":
                   $tb = new DBTable($ref_id);
                   if($tb->load()){
                     $ob = new Object3D(0, $posx, $posy, $posz, $size, $ref_id, $material, $texture,$color, $opacity);
                     if($ob->save())
                       return ["Success"];
                     else
                       return ["Fail"];
                   }else{
                     throw new Exception("API ERROR - Invalid table id passed.");
                   }
                 break;
                 case "column":
                   $col = new DBCol($ref_id);
                   if($col->load()){
                     $ob = new Object3D(0, $posx, $posy, $posz, $size, $ref_id, $material, $texture,$color, $opacity);
                     if($ob->save())
                       return ["Success"];
                     else
                       return ["Fail"];
                   }else{
                     throw new Exception("API ERROR - Invalid column id passed.");
                   }
                 break;
                 default:
                  throw new Exception("API ERROR - invalid type ".$type.".");
                 break;
               }
             }

           }
        }else{
          throw new Exception("API ERROR - Invalid request - few parameters(".count($info).")");
        }
       }
     }
 }

 ?>
