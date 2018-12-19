<?php

namespace App\Http\Controllers;

use App\Aboutus;
use App\Contact;
use App\FunctionTable;
use App\GuidingPrinciples;
use App\Leadership;
use App\MessageFromLeader;
use App\Mission;
use App\User;
use App\Vision;
use App\BusinessAtGlance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        //
        $uname=$request->userName;
        $pass=$request->password;

        $email = $uname;

        $user = User::where('email',$email)
            ->first();

        //dd($user);
        //exit;

        if($user){

            if (Hash::check($pass, $user->password)) {
                //The passwords match...
                //echo "The passwords match";
                $this->makeJson_for_Autherised_user();
            }else{
                //echo "passwords Not match";
                $this->makeJson_for_Unautherised_user();
            }
        }
        else{
            echo "email or pass not matched !";
        }

    }

    public function makeJson_for_Autherised_user(){

            $myobj_1 = new myobj();
            $myobj_1->status=200;
            $myobj_1->message="successfull";
            //$myobj_1->userprofile="robin";

            $myobj_2 = new myobj();
            $myobj_2->isvalid= true;

            $myobj_3 = new myobj();
            $myobj_3->name="Admin";
            $myobj_3->image="https://www.w3schools.com/howto/img_avatar2.png";
            $myobj_3->designation="territory officer";

            $myarr= array('meta'=>$myobj_1,'validity'=>$myobj_2,'userprofile'=>$myobj_3);

            $myJSON = json_encode($myarr);

            echo $myJSON;

    }
    public function makeJson_for_Unautherised_user(){

            $myobj_1 = new myobj();
            $myobj_1->status="401";
            $myobj_1->message="Authentication Failed";
            //$myobj_1->userprofile="robin";

            $myobj_2 = new myobj();
            $myobj_2->isvalid=false;

            $myarr= array('meta'=>$myobj_1,'validity'=>$myobj_2);

            $myJSON = json_encode($myarr);

            echo $myJSON;

    }


    public function welcome_bat(){


        $about_us = Aboutus::find(1);


        $vision = Vision::find(1);
        $mission = Mission::find(1);


        $guides = GuidingPrinciples::all();

        $i=0;
        foreach($guides as $guide){
            $guide_obj[$i] = [
                "image"=> $guide->image,
                "description"=> $guide->description,
                "title"=> $guide->title,
            ];

            $i++;
        }

        //exit;



        $obj =  [
            'Bat' => [
                [
                    "requestFor"=> "about us",
                    "data"=> [
                        "image"=> $about_us->upperimage,
                        "description"=> $about_us->description,
                        "title"=> $about_us->title,
                    ],
                ],
                [
                    "requestFor"=> "vision",
                    "data"=> [
                        "image"=> $vision->image,
                        "description"=> $vision->description,
                        "title"=> $vision->title,
                    ],
                ],
                [
                    "requestFor"=> "mission",
                    "data"=> [
                        "image"=> $mission->image,
                        "description"=> $mission->description,
                        "title"=> $mission->title,
                    ],
                ],
                [
                    "requestFor"=> "guiding principles",
                    "dataset"=> $guide_obj,
                ],

            ],
        ];



        //return $obj['Bat'][3]['data'];
        return $obj;
    }


    public function contact_api(){

        $contacts = Contact::all();

        $i=0;
        foreach($contacts as $contact){
            $contacts_obj[$i] = [
                "id"=> $contact->id,
                "name"=> $contact->name,
                "function"=> $contact->function,
                "contact"=> $contact->contact,
            ];
            $i++;
        }

        $obj = [
            "contactlist"=> $contacts_obj,

        ];

        return $obj;

    }

    public function leadership_api(){
        $leaderships = Leadership::all();


        $leaderships_obj = array();
        $message_array = array();

        $message_0 = MessageFromLeader::where('leadership_id',1)->get();
        $message_1 = MessageFromLeader::where('leadership_id',2)->get();


        for($k=0;$k<2;$k++){
            $j = 0;
            if($k==0){
                $messages = $message_0;
            }elseif($k == 1){
                $messages = $message_1;
            }

            foreach( $messages as $message){
//            echo $message->title."<br>";
                $message_array[$k][$j] = [
                    "title"=>$message->title,
                    "msg"=>$message->message,
                ];
                $j++;
            }
        }
        //dd($message_array);

       // exit;

        $i=0;
        foreach($leaderships  as $leadership){
            $leaderships_obj[$i] = [
                "requestFor"=> $leadership->requestFor,
                "img"=> $leadership->img,
                "name"=> $leadership->name,
                /*"title"=> $leadership->title,*/
                "message"=> $message_array[$i],
            ];
            $i++;
        }

        $obj = [
            "leadership"=> $leaderships_obj,

        ];

//        return $obj['leadership'][0]['message'][1];
        return $obj;
    }
    public function business_at_a_glance()
    {
      $business= BusinessAtGlance::all();
$i=0;
foreach ($business as $a ) {
  $businessjson[$i]=[
"id"=> $a->id,
"title"=>$a->title,
"image"=>$a->image,
"description"=>$a->description,
];

$i++;
  // code...
}

      return $businessjson;

    }

    public function function_api(){
        $functions = FunctionTable::all();
        $functions_obj = array();

        $i=0;
        foreach($functions  as $function){
            $functions_obj[$i] = [
                "id"=> $function->id,
                "functionName"=> $function->functionName,
                "functionDetails"=> $function->functionDetails,
            ];
            $i++;
        }

        $obj = [
            "function"=> $functions_obj,

        ];

        return $obj;
    }

    public function check(){


        $obj =  [
            'Bat' => [
                [
                    "requestFor"=> "about us",
                    "data"=> [
                        "upperimage"=> "link",
                        "lowerimage"=> "link",
                        "description"=> "description of about us",
                        "title"=> "title",
                    ],
                ],
                [
                    "requestFor"=> "vision",
                    "data"=> [
                        "image"=> "link",
                        "description"=> "description of vision",
                        "title"=> "title",
                    ],
                ],
                [
                    "requestFor"=> "mission",
                    "data"=> [
                        "image"=> "link",
                        "description"=> "description of mission",
                        "title"=> "title",
                    ],
                ],
                [
                    "requestFor"=> "guiding principles",
                    "data"=> [
                        [
                            "image"=> "link",
                            "description"=> "description of guiding priciple one",
                            "title"=> "title",
                        ],
                        [
                            "image"=> "link",
                            "description"=> "description of guiding priciple two",
                            "title"=> "title",
                        ],
                    ],
                ],

            ],
        ];

       return $obj;
       //return $obj['Bat'][0] ;
       //return $obj['Bat'][1] ;
       //return $obj['Bat'][2] ;
       //return $obj['Bat'][3] ;

        exit;

        $email = "admin@admin.com";

        $user = User::where('email',$email)
            ->first();


        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'data' => $user->role_id,
            'links' => [
                'self' => 'link-value',
            ],
        ];
        exit;

        $email = "admin@admin.com";

        $user = User::where('email',$email)
                ->first();

        //dd($user);
        //exit;

        if($user){
            //echo $user->name."<br><hr>";
            //echo $user->email."<br><hr>";
            //echo $user->password."<br><hr>";
            //echo $user->role_id."<br><hr>";

            //$password = Hash::make('password');

            //echo $password."<br>";

            if (Hash::check('password', $user->password)) {
                //The passwords match...
                echo "The passwords match";
            }else{
                echo "passwords Not match";
            }
        }
        else{
            echo "email or pass not matched !";
        }
    }




}

class myobj{

}
