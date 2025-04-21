<?php

namespace App\Repositories;

use App\Models\Persona;

class PersonaRepository extends Repository
{
    public function __construct(Persona $persona)
    {
        parent::__construct($persona);
    }
}
