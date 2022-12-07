<?php
function getPhenotypesFromDB(string $db_filepath) {
	// Query for unique chromosomes and unique phenotypes from sqlite database.
	 // Array will be used to populate dropdown menus.
	$db = new SQLite3($db_filepath);
	
	$results_phenotype = $db->query('SELECT DISTINCT phenotype FROM sv_phenotypes ORDER BY phenotype');
	$pheno_unique = array();
	while ($row_pheno = $results_phenotype->fetchArray(SQLITE3_BOTH)) {
		$pheno_label = $row_pheno[0];
		$pheno_str = strval($pheno_label);  // Convert to string
		$pheno_unique[] = $pheno_str;
	}
	
	return $pheno_unique;
}
?>
