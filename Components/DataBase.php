<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class DataBase
{
    private $pdo;


    // свойства которые относяться только методу к query;
    private $query, $error = false, $results = null, $count= null;
    public $massage = '';


//созданние приватного свойства для того чтобы по умолчанию подключение к бд было null реализация патерна сингелтон
    private static $instance = null;

// cоздание приватного construct  для того чтобы никто не мог получить доступ к нему реализация патерна сингелтон
    private function __construct()
    {
  // установка кодировки работает с версии PHP 5.3.6.
        $dsn = "".Config::get('mysql.driver').":host=".Config::get('mysql.host').";dbname=".Config::get('mysql.database').";charset=".Config::get('mysql.charset').";";

// установка pdo подключения
        try {
            $this->pdo = new PDO($dsn, Config::get('mysql.username'),Config::get('mysql.password'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            die ("Ошибка подключения к базе данных: ".$e->getMessage());
        }
        }

// реализация патерна сингелтона через подключение к базе данных
    public static function getInstance()

    {
        if (!isset(self::$instance)) {

            self::$instance = new Database();
        }

        return self::$instance;
    }

    //метод для выполнения запросов обертка
    //- получить все запись из таблицы универсальный метод
    public function query($sql, $params = [])
    {

        //ошибка по умолчанию false
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);
//проверка на сушествование масива
        if (count($params)) {
            $i = 1;
            //передача множества аргументов в value;
            foreach ($params as $value) {
                $this->query->bindValue($i, $value);
                $i++;
            }
        }

        // проверка на уход данных в бд
        if (!$this->query->execute()) {
            $this->massage = $this->query->errorInfo();
            $this->error = true;
            return $this;
        } else {


try{
   // выборка данных из бд
    $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                   //полученные количество колонок из бд
            $this->count = $this->query->rowCount();
}catch (PDOException $e){
    //проверка на операции обновления удаления и добавление так как выборки после них нет
                return  $this;
            }

        }
// передача только объекта создаваемого класса
        return $this;
    }

    //оберка над для SELECT метода и DELETE
    public function action($table, $where= [], $action)
    {
              $this->error = false;

        if (isset($where) and count($where) == 3) {
            //масив разрешеных операторов
            $operators = ['=', '>', '<', '>=', '<=', 'IS', 'IN', 'LIKE'];
            // разделения масива по переменим
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
// проверка если ли разрешеный оператор
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field}  {$operator} ?";

                if (!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            } else{

                $this->massage = 'не верно веден оператор';
            }
        } else {

            $this->massage = 'ведите три значения';
        }

        $this->error = true;
       return $this;
    }

////- получить все записи из таблици из таблицы по id или все записи

  public function get($table, $where = [])
    {
     return   $this->action($table, $where, 'SELECT *');
    }

    //    //- удалить запись из таблицы по id

    public function delete($table, $where = [])
    {
        return   $this->action($table, $where, 'DELETE');

    }

//вставка данных веденых форму

    public function insert($table, $fields = []) {


        $values= '';
        foreach ($fields as $key=>$field)
        {
            $values .="?,";
        }
        $values =rtrim($values, ',');

        $sql = "INSERT INTO {$table} (`".implode('`, `', array_keys($fields))."`) VALUES ({$values})";
        $this->query = $this->pdo->prepare($sql);

        if(!$this->query($sql,$fields)->error())
        {
            return $this;
        }
        return $this;
    }
//метод обновление данных пользователя
//   - обновить данные записи в таблице по id
    public function update($table, $id,$fields = []) {
        //удаляю последный елемент масива
//        array_pop($fields);
        $set= '';
        foreach ($fields as $key=>$field)
        {
            $set .=$key."=?,";
        }
        $set =rtrim($set, ',');

        try{
            $this->query = $this->pdo->prepare("SELECT id FROM users WHERE id ={$id} LIMIT 1 ");
            $this->query->execute();
        }catch (PDOException $e){
            if($this->query->rowCount() == 0 ){
                $this->massage = 'id в системе такого нет ' . $e->getMessage();
                $this->error = true;
                return $this;
            }
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id= {$id}";

        if(!$this->query($sql,$fields)->error())
        {
            return $this;
        }

        $this->error = true;
        return $this;
    }



    //метод выборки одного пользователя

    public function first()
    {
        return  $this->results()[0];
    }
// getter получает приватное свойство error
    public function error()
    {
        return $this->error;
    }

// getter получает приватное свойство results
    public function results()
    {
        return $this->results;
    }

// getter получает приватное свойство count

    public function count()
    {
        return $this->count;
    }

}
