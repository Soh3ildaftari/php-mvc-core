<?php
namespace app\core;
/**
 * Summary of Application
 * @author MasterMute <soheilsoheili1113@gmail.com>
 * @copyright (c) 2023
 */
class Application
{
    public static Application $app;
    public ?Controller $controller = null;
    public Session $session;
    public Router $router;
    public db\Database $db;
    public Request $request;
    public Response $response;
    public ?db\Dbmodel $user = null;
    public ?string $userClass;
    public static string $ROOT_DIR;
    public function __construct($rootPath,array $config)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->session = new Session();
        $this->db = new db\Database($config['db']);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
        $this->userClass = $config['userClass'];
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]) ?? null;
        }

    }
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
    public function run()
    {
        try {
            echo $this->router->resolve();
        }catch (\Exception $e) {
          echo Application::$app->controller->render('_error', ['exception' => $e] );
        }
    }
    public function login(db\Dbmodel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }
    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
