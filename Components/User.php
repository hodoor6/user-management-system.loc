<?php


class User
{
// $session_name - название сесии при авторизации
    private $db = null, $data = null, $session_name = null, $isLoggedIn, $cookieName;


//подключение к баз данных
    public function __construct($user = null)
    {
        $this->db = DataBase::getInstance();
        //получение имени сессии из $GLOBALS['config'] для дальнейшей использования
        $this->session_name = Config::get('session.user_session');
        $this->cookieName = Config::get('cookie.cookie_name');
        if (!$user) {
            if (Session::exists($this->session_name)) {
                $id = Session::get($this->session_name); //id
                // проверка нашло ли значение  передано в сесcии в бд если нашло вернет true
                if ($this->find($id)) {
                    $this->isLoggedIn = true;
                } else {
                    //logaut
                }
            }
        } else {
            // вывод пользователя без авторизации по id
            $this->find($user);
        }
    }

// создание пользователя //добавление пользователя в базу
    public function create($fields = [])
    {
        $this->db->insert('users', $fields);
    }

// обертка над update - обновление данных с формы
    public function update($fields = [], $id = null)
    {
        // проверка авторизованного пользователя если авторизирован берем id
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }
        $this->db->update('users', $id, $fields);
    }


// метод проверки пароля на совпадения и email для авторизации
    public function login($email = null, $password = null, $remember = false)
    {
        // проверка на существование данных пользователя когда есть куки когда не водился логин и пароль
        if (!$email && !$password && $this->exists()) {

            Session::put($this->session_name, $this->data()->id);
        } else {
            //поиск email по бд
            $user = $this->find($email);
            if ($user) {
                // проверка на совпадение по паролю
                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->session_name, $this->data()->id);
                    //проверка на чек бокс запомни меня
                    if ($remember) {
                        //создание хеша для куки
                        $hash = hash('sha256', uniqid());
                        // поиск id в таблице с user_sessions
                        $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->data()->id]);
                        // если id пользователя в таблице user_sessions // если нет записывает
                        if (!$hashCheck->count()) {
                            $this->db->insert('user_sessions', [
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        //запись в куки созданого hash или полученого hash из бд
                        Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }

// обертка над методом get для поиска по email или id в бд
    public function find($value = null)
    {
// проверка передаваемый тип
        if (is_numeric($value)) {
            $this->data = $this->db->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users', ['email', '=', $value])->first();
        }
        //проверка на существование данных после выборки
        if ($this->data) {
            return true;
        }
        return false;
    }


//Getter для вывода данных на frandtend
    public function data()
    {
        return $this->data;
    }

//Getter для вывода cостояния при авторизации
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    //удаление сессии при выходе из системы
    public function logout()
    {
        $this->db->delete('user_sessions', ['hash', '=', Cookie::get($this->data()->id)]);
        Cookie::delete($this->cookieName);
        return Session::delete($this->session_name);
    }

//проверка существует пользователь или нет
    public function exists()
    {
        return (!empty($this->data())) ? true : false;
    }

// проверяет совпадает ли пароль с текущим паролем пользователя авторизированного пользователя
    public function checkPassword($passwordForCheck = '', $passwordHash = null)
    {
        if (!$passwordHash && $this->isLoggedIn) {
            $passwordHash = $this->data()->password;
        }
        return password_verify($passwordForCheck, $passwordHash);

    }

    /**
     * Проверка прав доступа (роли). Принадлежность к группе
     */
    public function hasPermissions($key = null)
    {
        if ($key) {
            $group = $this->db->get('groups', ['id', '=', $this->data()->group_id]); // выборка из бд id группы пользователей
            if ($group->count()) {
                $permissions = $group->first()->permissions;
                // конвертация json данных в php массив
                $permissions = json_decode($permissions, true);
                //проверка на совпадение с ролью
                if (is_array($permissions) && $permissions[$key]) {
                    return true;
                }
            }
        }
        return false;

    }

    // вывод всех пользователей
    public function getAllUsers()
    {
        return  $this->db->get('users', ['id', '>', '0'])->results();
    }

    public function getOneUser($id)
    {
        return $this->db->get('users', ['id', '=', $id])->first();
    }


    public function delete($id){

        return $this->db->delete('users', ['id', '=', $id]);
    }

}