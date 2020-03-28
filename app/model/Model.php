<?php


class Model
{

    private $db = null;


//подключение к баз данных
    public function __construct()
    {
        $this->db = DataBase::getInstance();

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

    // вывод всех пользователей
    public function getAllUsers()
    {
        return $this->db->get('users', ['id', '>', '0'])->results();
    }

    public function delete($id){

        return   $this->db->delete('users', ['id', '=', $id]);
    }

}
