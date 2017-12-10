<html>
<head>
	<title>Language Model : Pos tagger</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/main.css">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap.min.css">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/font-awesome.min.css"> 
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
	<style>
		.colorgraph {
	  height: 5px;
	  border-top: 0;
	  background: #c4e17f;
	  border-radius: 5px;
	  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		}
  </style>
</head>
<body>
	
	<div class="container">
		<div class="row" style="margin-top:20px" align="center">
		  	<?php
				$total = 0;
				if(isset($mUnigram)){

				foreach ($mUnigram as $kata) {
					$total+=$kata['jumlah'];
				}
				echo "<div class='col-md-4'>";
				echo "Sumber corpus: wikipedia</br>";
				echo "</br>Jumlah kata pada korpus=".$total;
				echo "</br>Jumlah vocab/unigram=".count($mUnigram);
				echo "</br>Jumlah bigram=".count($mBigram)."</br>";
				echo "</div>";
				}

				echo "<div>";
				echo "<br><br>Team: ";
				echo "Ahmad Zainal A 1404862, ";
				echo "Febyana Ramadhanti 1404095, ";
				echo "Mira Nurhayati 1403754<br><br>";
				echo "</div>";
			?>
		  <div class="col-md-8 col-md-offset-2">
				

				<?php echo form_open('Main/tagger'); ?>
  					<fieldset>
  					<br>
						<hr class="colorgraph">
						<div class="form-group">
								<div class="row" align="left"><h3>&nbsp;&nbsp;&nbsp;Bangkitkan Tag</h3></div>
		            <input type="text" name="tag" id="tag" class="form-control input-lg" placeholder="Kalimat" required>
						</div>
						<div class="row">
							<div class="col-md-12 col-md-offset">
		          	<input type="submit" class="btn btn-lg btn-primary btn-block" value="Cek">
							</div>
						</div>

					</fieldset>
				<?php echo form_close(); ?>

						 

			</div>

		</div>
		
		<div class="row">
		  <?php
		    	$total = 0;
		    	if(isset($kata)){
		    		echo "<h2 align='center'>Hasil</h2>";
		    		$n = count($kata);
		    		for($i=0;$i<$n;$i++){
		    			echo "<b>";
		    			echo $kata[$i];
		    			echo "</b>";
		    			echo "/";
		    			echo $jenis[$i];
		    			echo "(";
		    			echo $persentase[$i];
		    			echo ") ";
		    		}
		    		echo "<br>";
		    		echo "<h2 align='center'>Beberapa kemungkinan pada setiap kata:</h2>";
		    		$m = count($opsiawal);
		    		for($i=0;$i<$m;$i++){
		    			echo "<b>";
		    			echo $opsiawal[$i]['kata_awal'];
		    			echo "</b>";
		    			echo "/";
		    			echo $opsiawal[$i]['jenis_awal'];
		    			
		    			echo "<b>";
		    			echo $opsiawal[$i]['kata'];
		    			echo "</b>";
		    			echo "/";
		    			echo $opsiawal[$i]['jenis'];
		    			echo "(";
		    			echo $opsiawal[$i]['persentase'];
		    			echo ")<br> >>>> emisi(";
		    			echo "<b>";
		    			echo $opsiawal[$i]['jenis'];
		    			echo "</b>";
		    			echo "|";
		    			echo "<b>";
		    			echo $opsiawal[$i]['kata'];
		    			echo "</b>";
		    			echo "):";
		    			echo $opsiawal[$i]['emisi'];
		    			echo "<br> >>>> transisi(";
		    			echo "<b>";
		    			echo $opsiawal[$i]['jenis'];
		    			echo "</b>";
		    			echo "|";
		    			echo "<b>";
		    			echo $opsiawal[$i]['jenis_awal'];
		    			echo "</b>";
		    			echo "):";
		    			echo $opsiawal[$i]['transisi'];
		    			echo ")<br>";
		    		}
		    	}
	    	?>
		</div>
		<br>
		
	</div>
</div>

</div>
	<div class="container">
	</div>
</body>

</html>