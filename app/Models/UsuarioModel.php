<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'correo', 'contrasena', 'rol'];
    protected $useTimestamps = true;
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';
}