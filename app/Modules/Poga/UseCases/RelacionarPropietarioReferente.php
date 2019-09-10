<?php

namespace Raffles\Modules\Poga\UseCases;

use Raffles\Modules\Poga\Models\{ Inmueble, Persona };

use Illuminate\Foundation\Bus\DispatchesJobs;

class RelacionarPropietarioReferente
{
    use DispatchesJobs;

    /**
     * The form data.
     *
     * @var array $data
     */
    protected $data;

    /**
     * The Persona and Inmueble models.
     *
     * @var Persona  $persona
     * @var Inmueble $inmueble
     */
    protected $persona, $inmueble;

    /**
     * Create a new job instance.
     *
     * @param Persona  $persona  The Persona model.
     * @param Inmueble $inmueble The Inmueble model.
     * @param array    $data     The form data.
     *
     * @return void
     */
    public function __construct(Persona $persona, Inmueble $inmueble, $data = [])
    {
        $this->persona = $persona;
        $this->inmueble = $inmueble;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $propietariosReferentes = $this->inmueble->personas()
            ->wherePivot('enum_estado', 'ACTIVO')
            ->wherePivot('enum_rol', 'PROPIETARIO')
            ->wherePivot('id_persona', '!=', $this->persona->id)
            ->wherePivot('referente', '1')
            ->get();


        return $this->inmueble->personas()->attach($this->persona->id, array_merge($this->data,
            [
                'enum_estado' => 'ACTIVO',
                'enum_rol' => 'PROPIETARIO',
                'referente' => '1',
            ]
        ));
    }
}
