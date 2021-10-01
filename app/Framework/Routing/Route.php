<?php
/**
 * @author      Bram(us) Van Damme <bramus@bram.us>
 * @copyright   Copyright (c), 2013 Bram(us) Van Damme
 * @license     MIT public license
 */
namespace App\Framework\Routing;

class Route
{
    static private $afterRoutes = [];
    static private $beforeRoutes = [];    
    static private $baseRoute = '';
    static private $requestedMethod = '';
    static private $serverBasePath;
    static private $namespace;
    static protected $notFoundCallback;

    public static function before($methods, $pattern, $fn)
    {
        $pattern = self::$baseRoute . '/' . trim($pattern, '/');
        $pattern = self::$baseRoute ? rtrim($pattern, '/') : $pattern;
        foreach (explode('|', $methods) as $method) {
            self::$beforeRoutes[$method][] = [
                'pattern' => $pattern,
                'fn' => $fn,
            ];
        }
    }

    public static function match($methods, $pattern, $fn)
    {
        $pattern = self::$baseRoute . '/' . trim($pattern, '/');
        $pattern = self::$baseRoute ? rtrim($pattern, '/') : $pattern;
        foreach (explode('|', $methods) as $method) {
            self::$afterRoutes[$method][] = [
                'pattern' => $pattern,
                'fn' => $fn,
            ];
        }
    }

    public static function all($pattern, $fn)
    {
        self::match('GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD', $pattern, $fn);
    }

    public static function get($pattern, $fn)
    {
        self::match('GET', $pattern, $fn);
    }

    public static function post($pattern, $fn)
    {
        self::match('POST', $pattern, $fn);
    }

    public static function patch($pattern, $fn)
    {
        self::match('PATCH', $pattern, $fn);
    }

    public static function delete($pattern, $fn)
    {
        self::match('DELETE', $pattern, $fn);
    }

    public function put($pattern, $fn)
    {
        self::match('PUT', $pattern, $fn);
    }

    public static function options($pattern, $fn)
    {
        self::match('OPTIONS', $pattern, $fn);
    }

    public static function mount($baseRoute, $fn)
    {
        $curBaseRoute = self::$baseRoute;
        self::$baseRoute .= $baseRoute;
        call_user_func($fn);
        self::$baseRoute = $curBaseRoute;
    }

    public static function getRequestHeaders()
    {
        $headers = [];
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            if ($headers !== false) {
                return $headers;
            }
        }

        foreach ($_SERVER as $name => $value) {
            if ((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')) {
                $headers[str_replace([' ', 'Http'], ['-', 'HTTP'], ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    public static function getRequestMethod()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            ob_start();
            $method = 'GET';
        }
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $headers = self::getRequestHeaders();
            if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], ['PUT', 'DELETE', 'PATCH'])) {
                $method = $headers['X-HTTP-Method-Override'];
            }
        }
        return $method;
    }

    public static function setNamespace($namespace)
    {
        if (is_string($namespace)) {
            self::$namespace = $namespace;
        }
    }

    public static function getNamespace()
    {
        return self::$namespace;
    }

    public static function run($callback = null)
    {
        self::$requestedMethod = self::getRequestMethod();
        // Handle all before middlewares
        if (isset(self::$beforeRoutes[self::$requestedMethod])) {
            self::handle(self::$beforeRoutes[self::$requestedMethod]);
        }
        // Handle all routes
        $numHandled = 0;
        if (isset(self::$afterRoutes[self::$requestedMethod])) {
            $numHandled = self::handle(self::$afterRoutes[self::$requestedMethod], true);
        }
        // If no route was handled, trigger the 404 (if any)
        if ($numHandled === 0) {
            if (self::$notFoundCallback) {
                self::invoke(self::$notFoundCallback);
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            }
        } // If a route was handled, perform the finish callback (if any)
        else {
            if ($callback && is_callable($callback)) {
                $callback();
            }
        }
        // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            ob_end_clean();
        }
        // Return true if a route was handled, false otherwise
        return $numHandled !== 0;
    }

    public static function set404($fn)
    {
        self::$notFoundCallback = $fn;
    }

    private static function handle($routes, $quitAfterRun = false)
    {
        // Counter to keep track of the number of routes we've handled
        $numHandled = 0;
        // The current page URL
        $uri = self::getCurrentUri();
        // Loop all routes
        foreach ($routes as $route) {
            // Replace all curly braces matches {} into word patterns (like Laravel)
            $route['pattern'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['pattern']);
            // we have a match!
            if (preg_match_all('#^' . $route['pattern'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                // Rework matches to only contain the matches, not the orig string
                $matches = array_slice($matches, 1);
                // Extract the matched URL parameters (and only the parameters)
                $params = array_map(function ($match, $index) use ($matches) {
                    // We have a following parameter: take the substring from the current param position until the next one's position (thank you PREG_OFFSET_CAPTURE)
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                    }
                    return isset($match[0][0]) ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                self::invoke($route['fn'], $params);
                ++$numHandled;

                if ($quitAfterRun) {
                    break;
                }
            }
        }

        return $numHandled;
    }
    private static function invoke($fn, $params = [])
    {
        if (is_callable($fn)) {
            call_user_func_array($fn, $params);
        }
        elseif (stripos($fn, '@') !== false) {
            list($controller, $method) = explode('@', $fn);
            if (self::getNamespace() !== '') {
                $controller = self::getNamespace() .'\\' . $controller;
            }
            if (class_exists($controller)) {
                if (call_user_func_array([new $controller(), $method], $params) === false) {
                    if (forward_static_call_array([$controller, $method], $params) === false);
                }
            }
        }
    }
    public static function getCurrentUri()
    {
        $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen(self::getBasePath()));

        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return '/' . trim($uri, '/');
    }

    public static function getBasePath()
    {
        if (self::$serverBasePath === null) {
            self::$serverBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }
        return self::$serverBasePath;
    }
    public function setBasePath($serverBasePath)
    {
        $this->serverBasePath = $serverBasePath;
    }
}
