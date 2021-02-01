<?php

/**
 * for handling routing
 */
class Router
{
    /**
     * a request instance
     *
     * @var Request $request
     */
    private $request;

    /**
     * the supported methods
     *
     * @var array
     */
    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    function __construct(Request $request)
    {
            $this->request = $request;
    }

    /**
     * call
     *
     * @param string $name
     * @param array $args
     * @return void
     */
    function __call($name, $args) : void
    {
            list($route, $method) = $args;

            if(!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
            }

            $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     * @return string $result
     */
    private function formatRoute($route) : string
    {
            $result = rtrim($route, '/');
            if ($result === '') {
            return '/';
            }
            return $result;
    }

    /**
     * return error for bad method
     *
     * @return void
     */
    private function invalidMethodHandler()
    {
            header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    /**
     * 404 for not found route
     *
     * @return void
     */
    private function defaultRequestHandler()
    {
            header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * Resolves a route
     */
    function resolve()
    {
            $methodDictionary = $this->{strtolower($this->request->requestMethod)};
            $formatedRoute = $this->formatRoute($this->request->requestUri);
            $method = $methodDictionary[$formatedRoute];

            if(is_null($method)) {
                $this->defaultRequestHandler();
                return;
            }

            echo call_user_func_array($method, array($this->request));
    }

    function __destruct()
    {
            $this->resolve();
    }
}