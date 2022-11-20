#!/usr/bin/env python

import os
import io
import pandas as pd
from owlready2 import *


def read_mondo_ids_from_vcf():
    pass


def read_vcf(obo, path):
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
        chrom_data = vcf_df.loc[i, 'CHROM']  # Chromosome number
        pos_data = vcf_df.loc[i, 'POS']  # Reference position, with the 1st base having position 1

        # Get the mondo phenotype
        info_data = vcf_df.loc[i, 'INFO']
        info_split = info_data.split(';')
        for info_row in info_split:
            if info_row.startswith('PHENO='):
                pheno_split = info_row.split('=')
                onto_split = pheno_split[-1].split(',')
                for onto_row in onto_split:
                    if onto_row.startswith('MONDO'):
                        mondo_split = onto_row.split(':')
                        mondo_id = mondo_split[-1]
                        mondo_field = 'MONDO_' + mondo_id
                        #mondo_phenotype = obo[mondo_field].label[0]
                        4

    return vcf_df


def get_phenotype_from_mondo_id(mondo_id):
    print("Loading MONDO ontology...")
    onto = get_ontology("http://purl.obolibrary.org/obo/mondo.owl").load()
    obo = onto.get_namespace("http://purl.obolibrary.org/obo/")
    mondo_field = 'MONDO_' + str(mondo_id)
    phenotype = obo[mondo_field].label[0]
    print("Loading complete.")
    print("Phenotype = ", phenotype)

    return obo


if __name__ == '__main__':
    obo = get_phenotype_from_mondo_id("0018838")
    vcf_df = read_vcf(obo, r'vcf/GRCh38.variant_call.clinical.pathogenic_or_likely_pathogenic.vcf')
