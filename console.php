<?php


include 'vendor/autoload.php';

$pass = 'w21w21njinji';

$ig = new \InstagramAPI\Instagram(true, true);
$ig->login('w_w884', $pass);


for ($i = 0; $i < 2; $i++) {
	publish($ig);
	sleep(2);
	$i = 0;
}

function publish($id)
{
	$pdo = App\Service\DB::get();
	$stmt = $pdo->prepare("
	    SELECT
	        *
	    FROM
	        tasks
	    WHERE
	        status = 0
	");
	$stmt->execute();
	$tasks = $stmt->fetchAll();

	foreach($tasks as $task) {
	    
	    $file = realpath('./uploads/' . sha1($task['id']) . '.jpg');
	    $metadata = ['caption' => $task['description']];
	    $ig->timeline->uploadPhoto($file, $metadata);
	    $stmt = $pdo->prepare("
	    UPDATE
	        tasks
	    SET
	        status = 1
	    WHERE
	        id = :id
	    ");
	    $stmt->execute([
	        ':id' => $task['id']
	    ]);
	}

}