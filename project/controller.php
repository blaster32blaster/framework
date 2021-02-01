<?php

include_once 'processData.php';
include_once 'home.php';

class Controller
{

    /**
     * data processor
     *
     * @var processData $processor
     */
    private $processor;

    public function __construct()
    {
        $this->processor = new processData;    
    }

    /**
     * handle get route
     *
     * @return void
     */
    public function get()
    {
        $home = new home;
        return $home->handle();
    }

    /**
     * handle post route
     *
     * @param Request $request
     * @return void
     */
    public function post(Request $request)
    {
        return $this->processor->handle($request);
    }
}