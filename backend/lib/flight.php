<?php

class Flight
{
    private static array $routes = [];
    private static array $services = [];

 
    public static function route(string $definition, callable $callback): void
    {
        [$method, $pattern] = explode(' ', trim($definition), 2);

        self::$routes[] = [
            'method'   => strtoupper($method),
            'pattern'  => $pattern,
            'callback' => $callback,
        ];
    }

    
    public static function register(string $name, string $className, array $params = []): void
    {
        self::$services[$name] = [
            'class'    => $className,
            'params'   => $params,
            'instance' => null,
        ];
    }

    public static function __callStatic($name, $arguments)
    {
        if (!isset(self::$services[$name])) {
            throw new Exception("Service '$name' not registered.");
        }

        if (self::$services[$name]['instance'] === null) {
            $def = self::$services[$name];
            self::$services[$name]['instance'] = new $def['class'](...$def['params']);
        }

        return self::$services[$name]['instance'];
    }

   
    public static function start(): void
    {
        $reqMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($uri, PHP_URL_PATH);

        $pos = strpos($uri, 'index.php');
        if ($pos !== false) {
            $uri = substr($uri, $pos + strlen('index.php'));
        }
        if ($uri === '') {
            $uri = '/';
        }

        foreach (self::$routes as $route) {
            if ($route['method'] !== $reqMethod) continue;

            $pattern = preg_replace('#/@([^/]+)#', '/(?P<$1>[^/]+)', $route['pattern']);
            $regex   = '#^' . $pattern . '$#';

            if (preg_match($regex, $uri, $matches)) {
                $params = [];

                foreach ($matches as $k => $v) {
                    if (!is_int($k)) $params[] = $v;
                }

                call_user_func_array($route['callback'], $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not found";
    }

   
    public static function request()
    {
        return new class {
            public function getBody(): string
            {
                return file_get_contents('php://input');
            }
        };
    }

    
    public static function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
