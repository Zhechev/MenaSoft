<?php
/**
 * Created by PhpStorm.
 * User: Mitacheto
 * Date: 02.5.2018 г.
 * Time: 10:35 ч.
 */

namespace Models;

class News
{
    private $host = 'localhost';
    private $dbname = 'mena';
    private $user = 'root';
    private $password = '';

    private $connection;

    public function __construct()
    {
      try {
        $this->connection = new \PDO("mysql:dbname=$this->dbname;host=$this->host", $this->user, $this->password);
      } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
      }
    }

    /**
     * @return resource
     */
    public function getDbConn()
    {
        return $this->connection;
    }

    public function getAllNews($date, $title, $sortDate, $sortTitle) 
    {
        $sql = "SELECT date(date_added), title, short_description, text FROM news";

        if (!empty($date) && !empty($title)) {
          $sql .= " WHERE date(date_added) = '" . $date . "' AND title LIKE '%" . $title . "%'";
        } else if (!empty($date)) {
          $sql .= " WHERE date(date_added) = '" . $date . "'";
        } else if (!empty($title)) {
          $sql .= " WHERE title LIKE '%" . $title . "%'";
        }

        if ($sortDate && $sortTitle) {
          $sql .= " ORDER BY date_added ASC, title ASC";
        } else {
          if ($sortDate) {
            $sql .= " ORDER BY date_added ASC";
          } else if ($sortTitle) {
            $sql .= " ORDER BY title ASC";
          }
        }

        $query = $this->getDbConn()->prepare($sql);
        $query->execute();

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }
}