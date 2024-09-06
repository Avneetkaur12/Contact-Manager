# Contact Manager

A Web Application to manage contacts with functionalities to add, view, edit, and delete entries.


## Run Locally

Clone the project

```bash
git clone https://github.com/Avneetkaur12/Contact-Manager.git
```

Go to the project directory

```bash
cd Contact-Manager
```

Start the server

```bash
php -S localhost:8000
```


## Environment Variables

To run this project, you will need to add the following environment variables to your /src/Database/ConnectionFactory.php file

`$host`
`$db`
`$user`
`$pass`


```php
try {
$host = 'localhost';  // Add your Host Name
$db = 'avneetdb1';    // Add your Database Name
$user = 'root';       // Add your DB User Name
$pass = 'pass123';    // Add your DB Password

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$options = [
PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        
PDO::ATTR_EMULATE_PREPARES   => false, ];

self::$connection = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
     throw new PDOException($e->getMessage(), (int)$e->getCode());
}
```

