<?php
class Router {
    protected $routes = [];
    protected $params = [];

    public function add($route, $params) {
        $this->routes[$route] = $params;
    }

    // Match the route to the routes in the routing table, setting the $params
    // property if a route is found.
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if ($url == $route) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function getRoutes() {
        return $this->routes;
    }
    public function getParams()
    {
        return $this->params;
    }
}