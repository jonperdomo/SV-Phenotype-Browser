# SV-Phenotype-Browser
Browse phenotype-specific structural variant breakpoint locations in the GRCh38 reference genome from the dbVar database.

Class project for Drexel BMES 550.

*Authors: Jon Perdomo, Monica Jesteen, Balsam Mohammad*

## Files
- Biomed_TwoLine.png
  - Front page Drexel logo image
- Final Project_Webpage.php
  - Main HTML/PHP webpage
- PlotGenerator.py
  - Generates histograms for each phenotype's SV locations
- SVPhenDatabaseGenerator.py
  - Generates a database associating phenotypes from the MONDO ontology database with MONDO IDs in the dbVar SV VCF file for GRCh38
- environment.yml
  - conda environment file
- sv_phenotypes.sqlite
  - Database file generated from SVPhenDatabaseGenerator.py
- php/generateTable.php
  - Function for generating the SV summary table
- php/getPhenotypesList.php
  - Function for generating a list of distinct phenotypes found in the **sv_phenotypes** database
- vcf/GRCh38.variant_call.clinical.pathogenic_or_likely_pathogenic.vcf
  - VCF file from dbVar containing annotated SVs with associated MONDO phenotype IDs
- Data/
  - Folder containing output histograms from PlotGenerator.py

## Installation
- To run the webpage, it is easiest to install AMPPS:
  - [https://ampps.com/](https://ampps.com/)

- Open the **localhost** location in AMPPS, and copy these files into that folder

- Run AMPPS and navigate the browser to the **localhost** location

![image](https://user-images.githubusercontent.com/14855676/206320973-2a755540-63b0-4cf3-8cc8-6dd602559fa3.png)

- Open **SV-Phenotype-Browser/Final Project_Webpage.php**
![image](https://user-images.githubusercontent.com/14855676/206321178-21ef17c7-6d08-47ae-b29d-ddaaaeb58a25.png)

- Select a phenotype and click **Submit**. Then select a chromosome:
![image](https://user-images.githubusercontent.com/14855676/206321537-8c2ef926-0640-4720-9909-664aacc03f0b.png)

