<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<html>
<head>
    <style>
        h1 {text-align: center;}
        h3 {text-align: center;}
        h4 {text-align: center;}
    </style>
</head>
    <h1>Exploration of Phenotype</h1>
    <h3>By: Monica Jesteen, Balsam Mohammad, and Jonathan Perdomo</h3>
    <h4>BMES 550-900</h4>
    <br><i>Instructions: Select a phenotype and a chromosome from the dropdown menus below.</i><br>
    <div></div>

    <?php
        // error_reporting(0);
    ?>

    <body>	

		<!-- Create the phenotype drop-down -->
		<?php
			// Query for unique chromosomes and unique phenotypes from sqlite database.
			 // Array will be used to populate dropdown menus.
			$db = new SQLite3('sv_phenotypes.sqlite');
			$results_phenotype = $db->query('SELECT DISTINCT phenotype FROM sv_phenotypes ORDER BY phenotype');
			$pheno_unique = array();
			while ($row_pheno = $results_phenotype->fetchArray(SQLITE3_BOTH)) {
				$pheno_label = $row_pheno[0];
				$pheno_str = strval($pheno_label);  // Convert to string
				$pheno_unique[] = $pheno_str;
			}
		?>
		
		<form method=post>
			<label><br>Select a phenotype:<br></label>
			<select name='phenotype'>
				<option selected='selected'>Select...</option>
				<?php 
					foreach($pheno_unique as $item_phenotype){
						echo "<option value='$item_phenotype'>$item_phenotype</option>";
					}
				?>				
			</select>
		<input type='submit' name='Submit' value='Submit'/>
		</form>
		
		<!-- On phenotype selection -->
		<?php
			if(isset($_POST["phenotype"]) and (strcmp($_POST["phenotype"], "Select...") !== 0)){
				// Show the phenotype
				$selected_phen = $_POST["phenotype"];
				echo "Selected phenotype is: " . $selected_phen;
				echo "<br>";

				// Get the chromosomes
				$db_chrom = new SQLite3('sv_phenotypes.sqlite');
				$query_str = "SELECT DISTINCT CHROM FROM SV_PHENOTYPES WHERE PHENOTYPE = '$selected_phen'";
				$chroms = $db_chrom->query($query_str);
				$chroms_arr = array();
				while ($chrom_row = $chroms->fetchArray(SQLITE3_BOTH)) {
					$chrom_value = $chrom_row[0];
					$chrom_str = strval($chrom_value);  // Convert to string
					$chroms_arr[] = $chrom_str;
				}
			   
			   // Show the table
			   //$sumtabs = escapeshellcmd('python sumtab.py "'.$arg_pheno.'"');
		   } else {
			   echo "None selected.";
		   }
		?>
		
		<!-- Show the chromsome drop-down -->
	<script>
	function selectionchanged(){
		// Format the chromosome value
		var chrom_tag_data = $('select#fruitselection option:selected').text();
		let chrom_tag_trim = chrom_tag_data.trim();
		let chrom_tag = chrom_tag_trim.replace('/', '_');
		
		console.log(chrom_tag);
		 if (chrom_tag === 'None'){
			$('img#thefruit').attr('src', 'Biomed_TwoLine.png');
		 }else{
			//Format the filepath
			var phen_str_esc = '<?php echo $selected_phen; ?>';
			let phen_str = unescape(phen_str_esc);
			console.log(phen_str);
			let image_filepath = 'Data/' + phen_str + '_Chr' + chrom_tag + '.png';
			console.log(image_filepath);
			$('img#thefruit').attr('src', unescape(image_filepath));
		 }
	}
	</script>

	</br>
	<select id=fruitselection onchange="selectionchanged()">
		<option value='None'>None</value>
		<?php
			if(isset($chroms_arr)){
				foreach($chroms_arr as $vc){
					echo "<option value='$vc'>$vc</option>";
				}
			}
		?>
	</select>

	<img id=thefruit src='Biomed_ThreeLine.png'>
		<!--
		<form method=post>
			<label><br>Select a chromosome:<br></label>
			<select name='phen_chrom'>
				<option selected='chrom_selected'>Select...</option>
			<?php
				if(isset($chroms_arr)){
					foreach($chroms_arr as $vc){
						echo "<option value='$vc'>$vc</option>";
					}
				}
			?>
			</select>
		<input type='submit' name='submit_chrom' value='Submit'/>
		</form>
		-->
		
        <h3>Histogram of Phenotype Location </h3>

    </body>
</html>
