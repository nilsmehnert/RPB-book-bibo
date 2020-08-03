<?php

// error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);




/* Read XLS */

require_once 'libs/ExcelReader/Excel/reader.php';

$data = new Spreadsheet_Excel_Reader();

// Set output Encoding.
$data->setOutputEncoding('CP1251');

$data->read('MeineBibliothek.xls');

$books = array();
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { // $i = 1 ist die Kopfzeile mit dem Feldernahmen
	$books[$i]["title"] = utf8_encode($data->sheets[0]['cells'][$i][1]);
	$books[$i]["autoren"] = utf8_encode($data->sheets[0]['cells'][$i][2]);
	$books[$i]["schriftenreihe"] = $data->sheets[0]['cells'][$i][3];
	$books[$i]["kategorien"] = $data->sheets[0]['cells'][$i][4];
	$books[$i]["prublikationsdatum"] = $data->sheets[0]['cells'][$i][5];
	$books[$i]["verlag"] = $data->sheets[0]['cells'][$i][6];
	$books[$i]["seiten"] = $data->sheets[0]['cells'][$i][7];
	$books[$i]["isbn"] = $data->sheets[0]['cells'][$i][8];
	$books[$i]["kommentar"] = $data->sheets[0]['cells'][$i][11];
	$books[$i]["zusammenfassung"] = utf8_encode($data->sheets[0]['cells'][$i][12]);
	$books[$i]["coverpfad"] = $data->sheets[0]['cells'][$i][13];
	
}

$colors = array(
	0 => "#725864", 
	1 => "#693b47", 
	2 => "#f7e5be", 
	3 => "#d09393", 
	4 => "#a38080"
);
			
			
			
?>
<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		
		
		<link rel="stylesheet" href="res/style.css" >
		<script src="res/script.js"></script>
		</head>
		<body>
		
		
<div class="bookslider">
  <div class="footer"><a class="btn" id="prev" href="#" ripple="" ripple-color="#666666">Prev</a><a class="btn" id="next" href="#" ripple="" ripple-color="#666666">Next</a></div>
  <div class="books">
				<?
	foreach($books as $num =>$book){
		if($book["coverpfad"] == "") continue;
	?>
		<div class="book <?if($num ==2){echo "active";}?>" product-id="<?=$num?>" product-color="<?=$colors[$num % 5]?>">
			  <?if($book["coverpfad"] != ""){?><div class="thumbnail"><img src='<?=substr($book["coverpfad"], 1)?>'></div><?}?>
			  <h1 class="title"><?=$book["title"]?></h1>
				<?echo "<p class='description'><b>Title</b>: ".$book['title'];?>
				<?if($book["autoren"] != ""){ echo "<br><b>Autoren</b>: ".$book['autoren'];}?>
				<?if($book["kategorien"] != ""){ echo "<br><b>Kategorie</b>: ".$book['kategorien'];}?>
				<?if($book["verlag"] != ""){echo "<br><b>Verlag</b>: ".$book['verlag'];}?>
				<?if($book["isbn"] != ""){echo "<br><b>ISBN</b>: ".$book['isbn'];}?>
				<?if($book["kommentar"] != ""){echo "<br><b>Kommentar</b>: ".$book['kommentar'];}?>
				<?if($book["zusammenfassung"] != ""){echo "<br><b>Zusammenfassung</b>: ".$book['zusammenfassung'];}?>
				
				<?echo "</p>";?>
		</div>
	<?
	}
	?>
  </div>
</div>
		
		
		
		

			<?//echo "<pre>".print_r($books, true)."</pre>";?>
			<div class="accordion" id="books">
				<?
	foreach($books as $num =>$book){
		?>

				<div class="card">
					<div class="card-header" id="heading<?=$num?>">
						<h2 class="mb-0">
							<button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse<?=$num?>" aria-expanded="false" aria-controls="collapse<?=$num?>">
								<?=$book["title"]?>
							</button>
						</h2>
					</div>
					<div id="collapse<?=$num?>" class="collapse" aria-labelledby="heading<?=$num?>" data-parent="#books">
						<div class="card-body">
							<?if($book["coverpfad"] != ""){echo "<p><img src='".substr($book["coverpfad"], 1)."'></p>";}?>
							<?if($book["title"] != ""){ echo "<p><b>Title</b>: ".$book['title']."</p>";}?>
							<?if($book["autoren"] != ""){ echo "<p><b>Autoren</b>: ".$book['autoren']."</p>";}?>
							<?if($book["kategorien"] != ""){ echo "<p><b>Kategorie</b>: ".$book['kategorien']."</p>";}?>
							<?if($book["verlag"] != ""){echo "<p><b>Verlag</b>: ".$book['verlag']."</p>";}?>
							<?if($book["isbn"] != ""){echo "<p><b>ISBN</b>: ".$book['isbn']."</p>";}?>
							<?if($book["kommentar"] != ""){echo "<p><b>Kommentar</b>: ".$book['kommentar']."</p>";}?>
							<?if($book["zusammenfassung"] != ""){echo "<p><b>Zusammenfassung</b>: ".$book['zusammenfassung']."</p>";}?>
						</div>
					</div>
				</div>
				<?	
	}	
	?>

			</div>


		</body>
		