<?php

namespace Raffles\Modules\Poga\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, RedirectsUsers, ValidatesRequests;

    /**
     * The custom Guzzle configuration options.
     *
     * @var array
     */
    protected $guzzle = [];

    /**
     * The HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * Get the base URL.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return "//homologacion.mavaite.com/poga-api-rest/api/v1/";
    }

    /**
     * Get a instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client($this->guzzle);
        }

        return $this->httpClient;
    }

    /**
     * Set the Guzzle HTTP client instance.
     *
     * @param  \GuzzleHttp\Client $client
     * @return $this
     */
    public function setHttpClient(Client $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Set enum_estado to 'INACTIVO' for the model.
     *
     * @param mixed $model The model.
     *
     * @return mixed $model
     */
    protected function disableModel($model)
    {
        $model->enum_estado = 'INACTIVO';
        $model->save();

        return $model;
    }
}
