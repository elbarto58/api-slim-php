<?php

//nombre de espacio para nuestro modelo, indicando donde està (locaciòn) para evitar colisiones
namespace app\models;
//importamos eloquent para usarlo en nuestro modelo
use Illuminate\Database\Eloquent\Model;
/**
 * Definimos nuestro modelo extendiendolo de eloquent
 */
class UserModel extends Model{
	//Definimos la llave primaria de la tabla: tbl_users
	protected $primary_key = 'id';
	//Definimos el nombre de nuestra tabla
	protected $table = 'tbl_users';
	//definimos los campos de la tabla mencionada a llenar
	protected $fillable = [
		'u_fullname',
		'u_email',
		'u_phone',
		'u_password'
	];
	
	public $timestamps = false;
}

?>