<?php
require_once __DIR__."/router.php";

session_start();
if(isset($_SERVER["REQUEST_URI"])){
    $isUrlFound = false;
    $uri = $_SERVER["REQUEST_URI"];
    foreach ($routers as $router){
        $routerSlashed = str_replace("/", "\/", $router["url"]);
        $result = preg_match("/".$routerSlashed."/", $uri, $matches);
        if($result == 1){
            unset($matches[0]);
            if(count($matches) > 0){
                sort($matches);
            }
            try{
                $userController = new \src\controller\UserController();
                if($userController->checkSession() && $router["type"]!="check"){

                        $controllerName = "\\src\\controller\\" . $router["class"] . "Controller";
                        $controller = new $controllerName;
                        $actionName = $router["action"];
                        $templateFile = $router["template"];
                        $templateFilePath = __DIR__ . "/src/view/" . $templateFile;
                        $returnValue = call_user_func_array(array($controller, $actionName), $matches);

                        if (!file_exists($templateFilePath)) {
                            echo "404";
                            exit;
                        }
                        $loader = new \Twig_Loader_Filesystem(__DIR__ . "/src/view");
                        $twig = new \Twig_Environment($loader, []);
                        $function = new Twig_SimpleFunction("generateUrl", "generateUrl");
                        $twig->addFunction($function);
                        $headerArray = array("userinfo"=>$userController->getUserInfo(),$userController->getServerAddress());

                        $template = $twig->load("header.twig");
                        echo $template->render($headerArray);

                        $template = $twig->load("leftmenu.twig");
                        echo $template->render(array());

                        $template = $twig->load($templateFile);
                        echo $template->render($returnValue);

                        $template = $twig->load("footer.twig");
                        echo $template->render($headerArray);

                        $isUrlFound = true;
                        break;
                }
                else if($router["type"]=="check"){
                        $controllerName = "\\src\\controller\\" . $router["class"] . "Controller";
                        $controller = new $controllerName;
                        $actionName = $router["action"];
                        $templateFile = $router["template"];
                        $templateFilePath = __DIR__ . "/src/view/" . $templateFile;
                        $returnValue = call_user_func_array(array($controller, $actionName), $matches);

                        if (!file_exists($templateFilePath)) {
                            echo "404";
                            exit;
                        }

                        $loader = new \Twig_Loader_Filesystem(__DIR__ . "/src/view");
                        $twig = new \Twig_Environment($loader, []);
                        $function = new Twig_SimpleFunction("generateUrl", "generateUrl");
                        $function = new Twig_SimpleFunction("redirectUrl", "redirectUrl");
                        $twig->addFunction($function);
                        $template = $twig->load($templateFile);
                        echo $template->render($returnValue);
                        $isUrlFound = true;
                        break;
                }
                else {
                    $templateFile = "login.twig";
                    $templateFilePath = __DIR__ . "/src/view/" . $templateFile;
                    $loader = new \Twig_Loader_Filesystem(__DIR__ . "/src/view");
                    $twig = new \Twig_Environment($loader, []);
                    $function = new Twig_SimpleFunction("generateUrl", "generateUrl");
                    $function = new Twig_SimpleFunction("redirectUrl", "redirectUrl");
                    $twig->addFunction($function);
                    $template = $twig->load($templateFile);
                    echo $template->render([]);
                    $isUrlFound = true;
                    break;
                }
            }catch (\Exception $exception){

                var_dump($exception->getMessage());exit;
            }
        }
    }
    if(!$isUrlFound){
        echo "404";
    }
    exit;
}

function generateUrl($alias){
    global $routers;
    if(isset($routers[$alias])){
        return $routers[$alias]["url"];
    }
    return "";
}

function redirectUrl($url){
    header('Location: '.$url);
}