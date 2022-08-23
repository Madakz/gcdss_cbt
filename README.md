# A computer based test app

Developed as a sample app for a school

Admin Password info
Username: MadakiF
Password: Bajoga2018

## Set up database thus:
Change this configuration from line 19 below to match that of your mySQL

try {
    $hostname ="localhost";
	$db_username = "root";
	$passwd = "madivel@";
	$dbname ="bajoga";
    $pdo_obj = new PDO("mysql:host=$hostname;dbname=$dbname", "$db_username", "$passwd");
    return $pdo_obj;
 }
 catch(PDOException $e)
    {
    return "Connection failed: " . $e->getMessage();
}