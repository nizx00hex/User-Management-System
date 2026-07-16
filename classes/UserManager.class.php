<?php

require_once 'Database.class.php';
require_once 'User.class.php';

class UserManager {
    private $db;


    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    //Create a user, it takes an array
    //done.
    public function createUser(User $user) {
        try {
            if(empty($user->getSecretName())) {
                $user->setSecretName();
            }
            
            $sql = "INSERT INTO `users` (`username`, `email`, `password`, `secret_name`, `full_name`, `status`, `ip_address`, `user_agent`)
VALUES (:username, :email, :password, :secret_name, :full_name, :status, :ip_address, :user_agent);";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':secret_name' => $user->getSecretName(),
                ':full_name' => $user->getFullName(),
                ':status' => $user->getStatus(),
                ':ip_address' => $user->getIpAddress(),
                ':user_agent' => $user->getUserAgent()

            ]);

            $userId = $this->db->lastInsertId();
            $this->logAction($userId, 'create');
            return $userId;

        } catch(PDOException $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
    }
    //done.
    public function getAllUsers() {
        try {
            $sql = "SELECT * FROM `users` WHERE `status` = 'active';";
            // echo "<br>";
            // print_r($sql);
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $users = [];
            while($row = $stmt->fetch()) {
                $users[] = new User($row);
            }
            // print_r($users);
            return $users;

        } catch(PDOException $e) {
            throw new Exception("Error fetching users: " . $e->getMessage());
        }
    }
    //done.
    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);

            if($row = $stmt->fetch()) {
                $this->logAction($id, 'read');
                
                $user = new User($row);
                return $user;
            }
            return null;

        } catch (PDOException $e){
            throw new Exception("Error fetching user: " . $e->getMessage());
        }
    }
    //done.
    public function getUserBySecretName($secret_name) {
        try {
            $sql = "SELECT * FROM users WHERE secret_name = :secret_name";
            
            // $sql = "SELECT * FROM users WHERE secret_name = '60f2c86f4d6ad469daa43920155de55d'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':secret_name' => $secret_name]);
            // $stmt->execute();

            var_dump($sql);
            var_dump($stmt);
            if($row = $stmt->fetch()) {
                // var_dump($row);
                echo $row;
                echo "worked";
                $this->logAction($row['id'], 'read_by_secret');
                return new User($row);
            } else {
                echo "not work";
            }
            return null;

        } catch (PDOException $e){
            throw new Exception("Error fetching user by secret name: " . $e->getMessage());
        }
    }
    //Pending
    public function updateUser(User $user) {
        try {

            $sql = "UPDATE users SET username = :username, email = :email,full_name = :full_name, status = :status, ip_address = :ip_address, user_agent = :user_agent WHERE id = :id";


            $params = [
                ':id' => $user->getId(),
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':full_name' => $user->getFullName(),
                ':status' => $user->getStatus(),
                ':ip_address' => $user->getIpAddress(),
                ':user_agent' => $user->getUserAgent()
            ];

            if($user->getPassword() !== null) {
                $sql = "UPDATE users SET username = :username, email = :email, password = :password, full_name = :full_name, status = :status, ip_address = :ip_address, user_agent = :user_agent WHERE id = :id";

                $params[':password'] = $user->getPassword();
            }

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($params);

            if($result){
                $this->logAction($user->getId(), 'update');
            }

            return $result;

        } catch (PDOException $e){
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            

            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':id' => $id]);


            if($result){
                printf("Worked");
                $this->logAction($id, 'delete');
            } else {
                printf("! result");
            }


            return $result;
        } catch(PDOException $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }


    public function disableUser($id) {
        try {
            $sql = "UPDATE `users` SET `status` = 'blocked', `updated_at` = now() WHERE ((`id` = :id));";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':id' => $id]);


            if($result){
                printf("Worked");
                $this->logAction($id, 'user blocked');
            } else {
                printf("! result");
            }


            return $result;
        } catch(PDOException $e) {
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function activeUser($id) {
        try {
            $sql = "UPDATE `users` SET `status` = 'active', `updated_at` = now() WHERE ((`id` = :id));";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':id' => $id]);


            if($result){
                printf("Worked");
                $this->logAction($id, 'user activated');
            } else {
                printf("! result");
            }


            return $result;
        } catch(PDOException $e) {
            throw new Exception("Error activating user: " . $e->getMessage());
        }
    }

    public function searchUsers($keyword) {
        try {
            $sql = "SELECT * FROM users WHERE username LIKE :keyword OR email LIKE :keyword OR full_name LIKE :keyword OR secret_name LIKE :keyword OR ip_address LIKE :keyword ORDER BY created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':keyword' => '%' . $keyword . "%"]);

            $users = [];
            while ($row = $stmt->fetch()) {
                $users[] = new User($row);
            }
            //$_SESSION['user_id'] = $user->getId();
            $this->logAction($_SESSION['user_id'] , 'search', $keyword);

            $this->logAction(null , 'search', $keyword);
            return $users;
        } catch (PDOException $e) {
            throw new Exception("Error searching user: " . $e->getMessage());
        }
    }
    //activate and disable
    public function toggleUserStatus($id) {
        try {
            $user = $this->getUserById($id);
            if(!$user) {
                throw new Exception("User not found");
            }
            $newStatus = $user->getStatus() === 'active' ? 'blocked' : 'active';

            $sql = "UPDATE users SET status = :status WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':status' => $newStatus, ':id' => $id]);

            if($result) {
                $this->logAction($id, 'toggle_status', $newStatus);
            }

            return ['success' => $result, 'new_status' => $newStatus];
        } catch(PDOException $e) {
            throw new Exception("Error toggling user status: " . $e->getMessage());
        }
    }


    public function updateLastLogin($id) {
        try {
            $sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id'=> $id]);
        } catch(PDOException $e) {
            throw new Exception("Error updating last login: " . $e->getMessage());
        }
    }

    public function logAction($user_id, $action, $details = null) {
        try {
            $sql = "INSERT INTO user_audit_log (user_id, action, ip_address, user_agent) VALUES (:user_id, :action, :ip_address, :user_agent)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':action' => $action . ($details ? '(' . $details . ')' : ''),
                ':ip_address' => $this->getClientIP(),
                ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
                ]);
            printf("Hello");
        } catch(PDOException $e) {
            error_log("Error logging action: " . $e->getMessage());
        }
    }

    public function getClientIP() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];

        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}