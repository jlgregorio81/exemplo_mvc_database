<?php
namespace app\dao;

use app\model\ClientModel;
use core\dao\Connection;
use core\dao\IDao;



class ClientDao implements IDao
{

    /**
     * Persists a model in database
     */
    public function insert(ClientModel $model = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "insert into client (name, birth, gender) values (:name, :birth, :gender)";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":name", $model->getName());
            $stmt->bindValue(":birth", $model->getBirthDate());
            $stmt->bindValue(":gender", $model->getGender());
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function update(ClientModel $model = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "update client set name = :name, birth = :birth, gender = :gender where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $model->getId());
            $stmt->bindValue(":name", $model->getName());
            $stmt->bindValue(":birth", $model->getBirthDate());
            $stmt->bindValue(":gender", $model->getGender());
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function delete($id)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "delete from client where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    /**
     * This method retrieves a model object from data base 
     * using an 'id' as input parameter.
     */
    public function findById($id)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "select * from client where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result) {
                $result = $result[0];
                return new ClientModel(
                    $result['id'],
                    $result['name'],
                    $result['birth'],
                    $result['gender']
                );
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function select($name = '%', $gender = '%', $orderBy = 'name')
    {
        try {
            $connection = Connection::getConnection();
            $sql = "select * from client where upper(name) like upper(:name) and upper(gender) like upper(:gender) order by $orderBy";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":gender", $gender);                        
            $result = $stmt->execute();            
            $result = $stmt->fetchAll();
            if ($result) {
                $clientList = new \ArrayObject();
                foreach ($result as $row) {
                    $clientList->append(
                        new ClientModel(
                            $row['id'],
                            $row['name'],
                            $row['birth'],
                            $row['gender']
                        )
                    );
                }
                return $clientList;
            } else {
                return null;
            }
        } catch (\Exception $ex) { 
            throw $ex;
        } finally {
            $connection = null;
         }
    }
}
