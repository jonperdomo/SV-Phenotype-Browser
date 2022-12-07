#!/usr/bin/env python

import os
import io
import pandas as pd
import sqlite3
from owlready2 import *


def generate_phen_database(obo, path):
    # Create the database
    db_filepath = r"sv_phenotypes.sqlite"
    conn = sqlite3.connect(db_filepath)

    # Create a table
    conn.execute('CREATE TABLE IF NOT EXISTS SV_PHENOTYPES (SV_ID VARCHAR(50), CHROM VARCHAR(10), SV_START INTEGER, '
                 'SV_END INTEGER, PHENOTYPE VARCHAR(50));')
    conn.commit()  # make sure to commit() so your changes are saved.

    # Open the file
    with open(path, 'r') as f:
        lines = [l for l in f if not l.startswith('##')]

    str_io = io.StringIO(''.join(lines))
    vcf_df = pd.read_csv(str_io,
        dtype={'#CHROM': str, 'POS': int, 'ID': str, 'REF': str, 'ALT': str,
               'QUAL': str, 'FILTER': str, 'INFO': str},
        sep='\t'
    ).rename(columns={'#CHROM': 'CHROM'})

    # Split data by chromosome, genomic location and MONDO phenotype
    row_count = vcf_df.shape[0]
    for i in range(row_count):
        sv_id = str(vcf_df.loc[i, 'ID'])  # SV ID
        chromosome_number = str(vcf_df.loc[i, 'CHROM'])  # Chromosome number
        start_position = int(vcf_df.loc[i, 'POS'])  # Reference position, with the 1st base having position 1

        # Get the SV length and mondo phenotype
        info_data = vcf_df.loc[i, 'INFO']
        info_split = info_data.split(';')
        mondo_phenotype = ''
        end_position = -1
        for info_row in info_split:
            if info_row.startswith('END='):
                end_split = info_row.split('=')
                end_position = int(end_split[-1])

            elif info_row.startswith('PHENO='):
                pheno_split = info_row.split('=')
                onto_split = pheno_split[-1].split(',')
                for onto_row in onto_split:
                    if onto_row.startswith('MONDO'):
                        mondo_split = onto_row.split(':')
                        mondo_id = mondo_split[-1]
                        try:
                            mondo_field = 'MONDO_' + mondo_id
                            mondo_phenotype = obo[mondo_field].label[0]

                        except Exception as e:
                            print("Phenotype error: ")
                            print(e)

        # Store in the database
        if mondo_phenotype != '' and end_position != -1:

            # Insert data into the table
            exec_str = f'INSERT INTO SV_PHENOTYPES(SV_ID, CHROM, SV_START, SV_END, PHENOTYPE) VALUES ("{sv_id}",' \
                       f'"{chromosome_number}", "{start_position}", "{end_position}", "{mondo_phenotype}")'
            conn.execute(exec_str)

            print("Stored: ", mondo_phenotype)

    conn.commit()
    conn.close()

    return vcf_df


def get_phenotype_ontology():
    print("Loading MONDO ontology...")
    onto = get_ontology("http://purl.obolibrary.org/obo/mondo.owl").load()
    obo = onto.get_namespace("http://purl.obolibrary.org/obo/")
    print("Loaded.")

    return obo


if __name__ == '__main__':
    obo = get_phenotype_ontology()
    vcf_df = generate_phen_database(obo, r'vcf/GRCh38.variant_call.clinical.pathogenic_or_likely_pathogenic.vcf')
