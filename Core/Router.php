<?php
class Router {
    protected $routes = [];
    protected $params = [];

    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    // Match the route to the routes in the routing table, setting the $params
    // property if a route is found.
    public function match($url)
    {
        // Match to the fixed URL format /controller/action
        // Forward Slash at the beginning ^ and end $
        // then lower case characters and - one or more
        // Capture groups to name the controller and action
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
                //$params = [];

                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

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