<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord
{

    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['cofirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensaje de validación para la creación de cuenta
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El campo \'Nombre\' no puede estar vacío.';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El campo \'Apelldio\' no puede estar vacío.';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El campo \'Teléfono\' no puede estar vacío.';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El campo \'Correo\' no puede estar vacío.';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El campo \'Clave\' no puede estar vacío.';
        }
        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La clave debe poseer mínimo 8 caracteres.';
        }

        return self::$alertas;
    }

    // Validar el inicio de sesión
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El campo \'Correo\' no puede estar vacío.';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El campo \'Clave\' no puede estar vacío.';
        }

        return self::$alertas;
    }

    // Validar si el usuario existe
    public function existeUsuario()
    {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El correo se encuentra asociado a otra cuenta';
        }
        return $resultado;
    }


    /* Hashear el password */
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    /* Enviar el Token único */
    public function crearToken()
    {
        $this->token = uniqid();
    }

    /* Comprobar y verificar el password */
    public function comprobarPasswordAndVerificado(){
        debuguear($this);
    }
}
