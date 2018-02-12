<html>
	<body>
		<form action="test.php" method="post">

		<p>Choose query:
			<input type="radio" name="query" value="0" hidden checked="checked" /> 1. How many Twitter users are in the database?</p>
			<input type="radio" name="query" value="1"  /> 1. How many Twitter users are in the database?</p>
			<input type="radio" name="query" value="2" /> 2. Which Twitter users link the most to other Twitter users? (Provide the top ten.)</p>
			<input type="radio" name="query" value="3" /> 3. Who is are the most mentioned Twitter users? (Provide the top five.)</p>
			<input type="radio" name="query" value="4" /> 4. Who are the most active Twitter users (top ten)?</p>
			<input type="radio" name="query" value="5" /> 5. Who are the five most grumpy (most negative tweets) and the most happy (most positive tweets)? (Provide five users for each group)</p>
		<p>Regex match: <input type="text" placeholder="happy|excited|glad" name="regex" /><br />
		<p>Mood:</br>
			<input type="radio" name="mood" value="1"  checked="checked" /> Negative</br>
			<input type="radio" name="mood" value="2"  /> Happiest</br>
		</p>
		<p><input type="submit" value="SEND"></p>
		</form>
	</body>
</html>

<?php 
var_dump($_POST);
if ($_POST['query'] != 0){
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27018");

	
			$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => '@', '$options' => 'g']]],
				['$group' => ['_id' => '$user', 'value' => ['$sum' => 1]]],
				['$sort' => ['value' => -1]],
				['$limit' => 10],
			],
			'cursor' => new stdClass,
		]);	
	
	
	if($_POST['query'] == '1'){
		echo "<h1>1. How many Twitter users are in the database?</h1>";
		$cmd = new MongoDB\Driver\Command([
			// build the 'distinct' command
			'distinct' => 'tweets', // specify the collection name
			'key' => 'user', // specify the field for which we want to get the distinct values
			'cursor' => new stdClass,

		]);
		$cursor = $manager->executeCommand('tweets', $cmd); // retrieve the results
		$unique = current($cursor->toArray())->values; // get the distinct values as an array
		
		echo "<h1>";

		echo count($unique);			
		echo "</h1>";
	}	
	if($_POST['query'] == '2'){
		echo "<h1>2. Which Twitter users link the most to other Twitter users? (Provide the top ten.)</h1>";

		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => '@', '$options' => 'g']]],
				['$group' => ['_id' => '$user', 'value' => ['$sum' => 1]]],
				['$sort' => ['value' => -1]],
				['$limit' => 10],
			],
			'cursor' => new stdClass,
		]);	
		
		
	}	
	if($_POST['query'] == '3'){
		echo "<h1>3. Who is are the most mentioned Twitter users? (Provide the top five.)</h1>";

		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => '@']]],
				['$project' => ['mentions' =>['$arrayElemAt' => [['$split' => ['$text', ' ']], 0]]]],
				['$group' => ['_id' => '$mentions', 'value' => ['$sum' => 1]]],
				['$sort' => ['value' => -1]],
				['$limit' => 10],
			],
			'cursor' => new stdClass,
		]);
		
		
	}	
	if($_POST['query'] == '4'){
		echo "<h1>4. Who are the most active Twitter users (top ten)?</h1>";

		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$group' => ['_id' => '$user', 'cnt' => ['$sum' => 1]]],
				['$sort' => ['cnt' => -1]],
				['$limit' => 10],
			],
			'cursor' => new stdClass,
		]);
		
		
	}	
	if($_POST['query'] == '5'){
		$reg = strlen ($_POST['regex']) > 0 ? $_POST['regex'] : '' ;
		$mood = $_POST['mood'] == 2 ? -1 : 1 ;
		$emotion = $mood == -1 ? 'happiest' : 'negative' ;
		echo "<h1>5. Who are the five most $emotion</h1>";

		echo "<h3>$reg</h3>";
		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => $reg, '$options' => 'g']]],
				['$group' => ['_id' => '$user', 'emotion' => ['$avg' => '$polarity']]],
				['$sort' => ['emotion' => $mood]],
				['$limit' => 5],
			],
			'cursor' => new stdClass,
		]);	
		
		
	}
	if($_POST['query'] != '1'){
	
	$cursor = $manager->executeCommand('tweets', $command);

    ?>
	<table>
    <?php 

	$i = 0;

	foreach($cursor as $document){
		if (!$i)
			{
			echo "<tr>";
			foreach($document as $key => $value)
				{
				echo "<th>$key</th>\n";
				}

			echo "</tr>";
			}

		echo "<tr>";
		foreach($document as $key => $value)
			{
			echo "<td>$value</td>\n";
			}

		echo "</tr>";
		$i++;
		} 	
	?>
	</table>
	<?php } ?>
	
	
	
<html>
<body>


</body>
</html>



<?php }?>
