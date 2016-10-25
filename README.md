# Phalcon - MS SQL Server (PDO) Adapter
- Phalcon 3.0.1 support
```php
$di->set('db', function() use ($config) {
	return new \Phalcon\Db\Adapter\Pdo\Mssql(array(
	    "name"         => "sqlsrv",
		"host"         => $config->database->host,
		"username"     => $config->database->username,
		"password"     => $config->database->password,
		"dbname"       => $config->database->name
	));
});

```
