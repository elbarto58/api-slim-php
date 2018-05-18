<?php
namespace app\controllers;
use app\models\UserModel;
use Psr\Log\LoggerInterface;
use Slim\Http\Request as Req;
use Slim\Http\Response as Res;

/**
	* Controlador que, a comparación del otro controlador -UserController-. este recibe solo peticiones POST para crear, leer, actualizar y eliminar datos sobre la misma tabla que accede el controlador antes mencionado.
*/
class UserPostController {
	private $logger;
	
	/**
		* Nuestro constructor, con el parametro de Logger, para almacenar errores o algún alerta en nuestro fichero log
	*/
	public function __construct(LoggerInterface $logger){
		$this->logger = $logger;
	}

	/**
		* C: Crea un registro nuevo de un usuario, y devuelve un json con: 
		* - un status (verdadero o falso según fue la respuesta a nuestra petición)
		* - un mensaje (un aviso)
		* - y los datos que se crearon (si no hubo problema)
		* @param type Slim\Http\Request $request - petición http
	 	* @param type Slim\Http\Response $response - respuesta http
	*/
	public function CreateUser(Req $req, Res $res){
		$message = '';//opcional - inicializar message en vacio
		$status = true;//estado inicial de nuestro status
		//getParsedBody() toma los parametros que trae nuestro req(petición) en json, xml, etc., y los parsea para que PHP lo entienda
		$data_req = $req->getParsedBody();
		//creamos un objeto de nuestro modelo de usuario para acceder a los campos declarados en fillable
		$data_user = new UserModel;
		$data_user->u_fullname = $data_req['u_fullname'];
		$data_user->u_email = $data_req['u_email'];
		$data_user->u_phone = $data_req['u_phone'];
		$data_user->u_password = $data_req['u_password'];
		//verificamos la respuesta del método save, si es true o false
		if($data_user->save()){//si todo salió bien -true-
			$message = 'Usuario creado exitosamente.';
		}else{//si algo salió mal -false-
			$status = false;
			$message = 'Hubo un error al guardar los datos del Usuario.';
		}
		//construimos nuestra respuesta con un objeto clave-valor con el status, msj y los datos obtenidos
		$data = [
			'status'=> $status,
			'message'=> $message,
			'data'=> $data_user
		];
		//retornamos nuestra respuesta en formato json para su posterior consumo
		return $res->withJson($data);
	}

	/**
		* R: Obtiene todos los registros de la tabla indicada, y devuelve un json con: 
		* - un status (verdadero o falso según fue la respuesta a nuestra petición)
		* - un mensaje (un aviso)
		* - y los datos que se obtuvieron (si es que hay)
		* @param type Slim\Http\Request $request - petición http
	 	* @param type Slim\Http\Response $response - respuesta http
	*/
	public function GetUsers(Req $req, Res $res){
		$message = '';//opcional - inicializar message en vacio
		$status = true;//estado inicial de nuestro status
		$data_users = UserModel::all();//consultamos registros de nuestra tabla indicada en el modelo
		//verificamos si esta vacio nuestra variable
		if ($data_users->isEmpty()) {//si NO hay datos
			$status = false;//si es asi, cambiamos nuestro status a falso, no hay datos.
			$message = 'No se encontraron datos para mostrar.';//un msj informativo
		}else{
			//si se encontraron datos, cambiamos de msj a exitoso
			$message = 'Se recuperaron los datos solicitados';
		}
		//construimos nuestra respuesta con un objeto clave-valor con el status, msj y los datos obtenidos
		$data = [
			'status'=> $status,
			'message'=> $message,
			'data'=> $data_users
		];
		//retornamos nuestra respuesta en formato json para su posterior consumo
		return $res->withJson($data);
	}

	/**
		* U: Actualiza el registro de un usuario mediante su id, y devuelve un json con: 
		* - un status (verdadero o falso según fue la respuesta a nuestra petición)
		* - un mensaje (un aviso)
		* - y los datos actualizados
		* @param type Slim\Http\Request $request - petición http
	 	* @param type Slim\Http\Response $response - respuesta http
	 	* @param type array $args - argumentos para la función, trae nuestro id
	*/
	public function UpdateUser(Req $req, Res $res, array $args){
		$message = '';//opcional - inicializar message en vacio
		$status = true;//estado inicial de nuestro status
		$data_req = $req->getParsedBody();
		$id = $data_req['id'];//cachamos el id del usuario a actualizar -por post-
		$data_user = UserModel::find($id);//buscamos al usuario mediante el id
		if($data_user){//si encontro algún dato relacionado
			$data_req = $req->getParsedBody();//parseamos nuestros datos de la petición
			//verificamos la respuesta del método update, si es true o false
			if ($data_user->update($data_req)) {//si todo salió bien
				$message = 'Usuario con id '.$id.' actualizado exitosamente';
			}else{//si algo salió mal -false-
				$message = 'Ocurrió un error al tratar de actualizar al usuario con el id '.$id;
				$status = false;
				$data_user = [];
			}
		}else{//si no encontro algún dato relacionado con el id
			$message = 'No se encontró a este usuario con este id '.$id;
			$status = false;
			$data_user = [];
		}
		//construimos nuestra respuesta con un objeto clave-valor con el status, msj y los datos obtenidos
		$data = [
			'status'=> $status,
			'message'=> $message,
			'data'=> $data_user
		];
		//retornamos nuestra respuesta en formato json para su posterior consumo
		return $res->withJson($data);

	}

	/**
		* D: Elimina el registro de un usuario mediante su id, y devuelve un json con: 
		* - un status (verdadero o falso según fue la respuesta a nuestra petición)
		* - un mensaje (un aviso)
		* - y los datos en vacio, como es eliminar
		* @param type Slim\Http\Request $request - petición http
	 	* @param type Slim\Http\Response $response - respuesta http
	 	* @param type array $args - argumentos para la función, trae nuestro id
	*/
	public function DeleteUser(Req $req, Res $res, array $args){
		$message = '';//opcional - inicializar message en vacio
		$status = true;//estado inicial de nuestro status
		//getParsedBody() toma los parametros que trae nuestro req(petición) en json, xml, etc., y los parsea para que PHP lo entienda
		$data_req = $req->getParsedBody();
		$id = $data_req['id'];//cachamos el id del usuario a eliminar -por post-
		$data_user = UserModel::find($id);//buscamos al usuario mediante el id
		if($data_user){//si encontro algún dato relacionado
			//verificamos la respuesta del método delete, si es true o false
			if ($data_user->delete()) {//si todo salió bien -true-
				$message = 'Usuario con id '.$id.' eliminado exitosamente';
			}else{//si algo salió mal -false-
				$message = 'Ocurrió un error al tratar de eliminar al usuario con id '.$id;
				$status = false;
			}
		}else{//si no encontró algún dato relacionado con el id
			$message = 'No se encontró a este usuario con este id '.$id;
			$status = false;
		}
		//construimos nuestra respuesta con un objeto clave-valor con el status, msj y los datos obtenidos
		$data = [
			'status'=> $status,
			'message'=> $message,
			'data'=> []
		];
		//retornamos nuestra respuesta en formato json para su posterior consumo
		return $res->withJson($data);
	}
}

?>