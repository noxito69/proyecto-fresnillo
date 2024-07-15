<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\ValidatorEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function index()
    {
       return response()->json(["msg"=>"Users finded",
        "data: "=>User::all(),],200);
    }



    public function store(Request $request)
    {

        $validate = Validator::make(
            $request->all(), [
                "name" => "required|max:30",
                "email" => "required|unique:users|email",
                "rol_id" => "numeric|between:1,4",
                "password" => "required|min:8|string",
                "num_empleado" => "required"
            ], [
                // Mensajes de error personalizados
                "name.required" => "El campo nombre es obligatorio.",
                "name.max" => "El nombre no debe ser mayor a 30 caracteres.",
                "email.required" => "El campo correo electrónico es obligatorio.",
                "email.unique" => "El correo electrónico ya está en uso.",
                "email.email" => "El correo electrónico debe ser una dirección válida.",
                "rol_id.numeric" => "El rol debe ser un número.",
                "rol_id.between" => "El rol debe estar entre 1 y 4.",
                "password.required" => "La contraseña es obligatoria.",
                "password.min" => "La contraseña debe tener al menos 8 caracteres.",
                "num_empleado.required" => "El número de empleado es obligatorio."
            ]
        );

        if ($validate->fails()) {
            return response()->json(["msg" => "Validación fallida", "errors" => $validate->errors()], 422);
        }

        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->rol_id=$request->rol_id;
        $user->num_empleado = $request->num_empleado;
        $user->is_active = true;
        $user->save();

        return response()->json(["msg"=>"User created, check your email","data"=>$user,],201);
    }

    public function update(Request $request,int $id)
    {
        $validate = Validator::make(
            $request->all(),[
                "name"=>"required|max:30",
                "email"=>"required|unique:users|email",
                "role_id"=>"numeric|between:1,3",
                "password"=>"min:8|string"
            ]
        );

        if($validate->fails())
        {
            return response()->json(["msg"=>"Data failed",
            "data:"=>$validate->errors()],422);
        }
        $user=User::find($id);
        if($user)
        {
            $user->name=$request->get('name',$user->name);
            $user->email=$request->get('email',$user->email);
            $user->password=$request->get('password',$user->password);
            $user->role_id=$request->get('role_id',$user->role_id);
            $user->save();
            return response()->json(["msg"=>"User updated","data"=>$user,],202);
        }
        return response()->json([
            "msg"   =>"Userd not found"
        ],404);

    }

    public function destroy(int $id)
    {
        $user=User::find($id);
        if($user){
            $user->is_active = false;
            $user->save();
            return response()->json(["msg"=>"User disabled","data"=>$user,],202);
        }
        return response()->json([
            "msg"   =>"User not found"
        ],404);
    }

    public function activate(User $user)
    {
        $user->is_active=true;
        $user->save();


    }

    public function login(Request $request) {
        $validate = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if($validate->fails()) {
            return response()->json(["error" => $validate->errors()], 400);
        }

        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json($user);
        }

        return response()->json(["error" => "Contraseña incorrecta"], 400);

    }

    public function recoverPassword(Request $request) {
        $validate = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
            "confirm_password" => "required"
        ]);

        if($validate->fails()){
            return response()->json(["error" => $validate->errors()], 400);
        }

        $user = User::where("email", $request->email)->first();

        if(!$user) {
            return response()->json(["error" => "Usuario no encontrado"], 404);
        }

        if($request->password === "" || $request->confirm_password === "") {
            return response()->json(["error" => "Debes de escribir una contraseña"], 400);
        }

        if($request->password !== $request->confirm_password) {
            return response()->json(["error" => "Las contraseñas no coinciden"]);
        }

        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json("Contraseña actualizada con éxito");
    }
}
