<?php
require_once "Database.class.php";
require_once 'User.class.php';
require_once 'UserManager.class.php';

// $conn = Database::getInstance();

// $data = [
//     'username' => 'nisath',
//     'password' => 'password'
// ];
// $user = new User($data);

// $user->setUsername("Nisath");
// $user->getUsername();
// $result = $user->setPassword("hiii");

// print($result);
// var_dump($conn);
// // $conn->getConnection();

// if($conn ) {
//     printf("Worked"); 
// }

echo "<pre>";


// echo "=== Test 1: Empty constructor ===\n";
// $user = new User();
// var_dump($user->getId()); // NULL
// var_dump($user->getUsername()); // NULL

// echo "\n=== Test 2: Individual setters ===\n";
// $user->setUsername("  johndoe  ");
// $user->setEmail("john@example.com");
// $user->setPassword("mypassword123");
// $user->setStatus("blocked");
// $user->setSecretName(); // test auto-generation

// echo "Username: '" . $user->getUsername() . "'\n"; // 'johndoe' (trimmed)
// echo "Password hash: " . $user->getPassword() . "\n"; // bcrypt hash, not plaintext
// echo "Status: " . $user->getStatus() . "\n"; // 'blocked'
// echo "Secret name: " . $user->getSecretName() . "\n"; // 16-char hex string

// echo "\n=== Test 3: Invalid status defaults correctly ===\n";
// $user->setStatus("hacked");
// echo "Status after invalid input: " . $user->getStatus() . "\n"; // should be 'active'

// echo "\n=== Test 4: hydrate() via constructor ===\n";
// $data = [
//     'id' => '5',
//     'username' => ' alice ',
//     'email' => 'alice@example.com',
//     'full_name' => 'Alice Smith',
//     'status' => 'active'
// ];
// $hydratedUser = new User($data);
// print_r($hydratedUser->toArray());

// echo "\n=== Test 5: password_verify sanity check ===\n";
// $u = new User();
// $u->setPassword("secret123");
// var_dump(password_verify("secret123", $u->getPassword())); // true
// var_dump(password_verify("wrongpass", $u->getPassword())); // false
// print_r($_SERVER['HTTP_USER_AGENT']);

//--------------------------------------------------------------------------

$user_m = new UserManager();

// $users = $user_m->getAllUsers();


$user = new User();


//CREATE USER
// $user->setUsername("logro");
// $user->setEmail("logro@example.com");
// $user->setPassword("password");   // gets hashed inside setPassword()
// $user->setFullName("Muhammed logro");
// $user->setStatus("active");
// $user->setIpAddress($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
// $user->setUserAgent($_SERVER['HTTP_USER_AGENT'] ?? 'CLI-Test');

// $newID = $user_m->createUser($user);


//GET ALL USER
// $users = $user_m->getAllUsers();
// print_r($users);

//GET USER BY ID 
// $user = $user_m->getUserById(5);
// print_r($user);

//GET USER BY SECRET NAME
// $sec_name = '60f2c86f4d6ad469daa43920155de55d';
// $newID = $user_m->getUserBySecretName($sec_name);
// print_r($newID);

//DELETE THE USER
// if($user_m->deleteUser(1)) {
//     echo "User disabled!";
// } else {
//     echo "User disabled failed";
// }

// //DISABLE THE USER
// if($user_m->disableUser(1)) {
//     echo "User disabled!";
// } else {
//     echo "User disabled failed";
// }

//ENABLE THE USER
// if($user_m->activeUser(1)) {
//     echo "User activated!";
// } else {
//     echo "User activated failed";
// }


// UPDATE USER
// $user->setUsername("NIZX00HEX");
// $newID = $user_m->createUser($user);


//SEARCH USERS
// $name = "hexon@example.com";
// $result = $user_m->searchUsers($name);
// print_r($result);


//TOGGLE USER
// $result = $user_m->toggleUserStatus(1);
// print_r($result);

//UPDATE LAST LOGIN
// $result = $user_m->updateLastLogin(1);
// print_r($result);

//LOG ACTION
// $result = $user_m->logAction(1, 'testing');
// print_r($result);


// print($newID);

// foreach($users as $user) {
//     echo "-----------------------------\n";
//     echo "ID: " . $user->getId() . "\n";
//     echo "Username: " . $user->getUsername() . "\n";
//     echo "Email: " . $user->getEmail() . "\n";
//     echo "Status: " . $user->getStatus() . "\n";
//     echo "Secret Name: " . $user->getSecretName() . "\n";
//     echo "Created At: " . $user->getCreatedAt() . "\n";
// }


echo "</pre>";

