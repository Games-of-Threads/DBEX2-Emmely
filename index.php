<html>
<head>
  <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="https://github.com/Games-of-Threads/DBEX2-Emmely">MongoDB Assignment</a>
          <!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">

	
	
​
<form action="index.php" method="post">
	<div class="col-12" style="border:1px solid #CCC">
		<!--Radio group-->
		<div class="form-group ">
			<input type="radio" name="query" value="0" hidden checked="checked" />
			<label for="radio100">Choose MongoDB query:</label>
		</div>
		<div class="form-group">
			<input type="radio" name="query" value="1" />
			<label for="radio101">1. How many Twitter users are in the database?</label>
		</div>
		<div class="form-group">
			<input type="radio" name="query" value="2" />
			<label for="radio102">2. Which Twitter users link the most to other Twitter users? (Provide the top ten.)</label>
		</div>
		<div class="form-group">
			<input type="radio" name="query" value="3" />
			<label for="radio102">3. Who is are the most mentioned Twitter users? (Provide the top five.)</label>
		</div>
		<div class="form-group">
			<input type="radio" name="query" value="4" />
			<label for="radio102">4. Who are the most active Twitter users (top ten)?</label>
		</div>
	</div>
	<div class="col-12" style="border:1px solid #CCC">
		<label for="basic-url">Mood query:</label>
		<div class="form-group">
			<input type="radio" name="query" value="5" />
			<label for="radio102">5. Who are the five most grumpy (most negative tweets) and the most happy (most positive tweets)? (Provide five users for each group)</label>
		</div>
		<!--Radio group-->
		<div class="input-group"> <span class="input-group-addon" id="basic-addon3">Regex match: </span>
			<input type="text" placeholder="happy|excited|glad" name="regex" class="form-control" aria-describedby="basic-addon3" />
			<br />
		</div>
		<p>Mood:</br>
			<div class="form-group">
				<input type="radio" name="mood" value="1" checked="checked" />
				<label for="radio102">Negative</label>
			</div>
			<div class="form-group">
				<input type="radio" name="mood" value="2" />
				<label for="radio102">Happiest</label>
			</div>
		</p>
		<div class="col-12">
			<input type="submit" class="btn btn-default" value="SEND"/>
		</div>
		</br>
	</div>
</form>
<div class="col-12" style="border:1px solid #CCC">


<?php 
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
		echo "<h5>1. How many Twitter users are in the database?</h5>";
		$cmd = new MongoDB\Driver\Command([
			// build the 'distinct' command
			'distinct' => 'tweets', // specify the collection name
			'key' => 'user', // specify the field for which we want to get the distinct values
			'cursor' => new stdClass,

		]);
		$cursor = $manager->executeCommand('tweets', $cmd); // retrieve the results
		$unique = current($cursor->toArray())->values; // get the distinct values as an array
		
		echo "<h5>";

		echo count($unique);			
		echo "</h5>";
	}	
	if($_POST['query'] == '2'){
		echo "<h5>2. Which Twitter users link the most to other Twitter users? (Provide the top ten.)</h5>";

		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => '@\w+', '$options' => 'g']]],
				['$group' => ['_id' => '$user', 'value' => ['$sum' => 1]]],
				['$sort' => ['value' => -1]],
				['$limit' => 10],
			],
			'cursor' => new stdClass,
		]);	
		
		
	}	
	if($_POST['query'] == '3'){
		echo "<h5>3. Who is are the most mentioned Twitter users? (Provide the top five.)</h5>";

		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => '@\w+']]],
				['$project' => ['mentions' =>['$arrayElemAt' => [['$split' => ['$text', ' ']], 0]]]],
				['$group' => ['_id' => '$mentions', 'value' => ['$sum' => 1]]],
				['$sort' => ['value' => -1]],
				['$limit' => 5],
			],
			'cursor' => new stdClass,
		]);
		
		
	}	
	if($_POST['query'] == '4'){
		echo "<h5>4. Who are the most active Twitter users (top ten)?</h5>";

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
		echo "<h5>5. Who are the five most $emotion</h5>";

		echo "<h3>$reg</h3>";
		$command = new MongoDB\Driver\Command([
			'aggregate' => 'tweets',
			'pipeline' => [
				['$match' => ['text' => ['$regex' => $reg, '$options' => 'g']]],
				['$group' => ['_id' => '$user', 'emotion' => ['$avg' => '$polarity'], 'total' => ['$sum' => 1]]],
				['$sort' => ['emotion' => $mood, 'total' => -1]],
				['$limit' => 5],
			],
			'cursor' => new stdClass,
		]);	
		
		
	}
	if($_POST['query'] != '1'){
	
	$cursor = $manager->executeCommand('tweets', $command);

    ?>
	<table class="table table-dark">
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
	
	
	




<?php }?>
</div>
	</div>
	</body>
</html>