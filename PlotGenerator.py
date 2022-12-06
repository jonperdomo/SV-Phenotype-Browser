#!/usr/bin/env python

import os
import io
import math
import pandas as pd
import sqlite3
from owlready2 import *
import matplotlib.pyplot as plt
import numpy as np


def generate_plots(db_filepath):
    """
    Query all rows in the tasks table
    :param conn: the Connection object
    :return:
    """
    print("Running...")
    sv_phenotype_dict = {}
    conn = sqlite3.connect(db_filepath)
    cur = conn.cursor()
    cur.execute("SELECT PHENOTYPE FROM SV_PHENOTYPES")
    rows = cur.fetchall()
    phenotype_set = set([v[0] for v in rows])
    for phenotype_str in phenotype_set:
        # Get the chromosomes for this phenotype
        db_command = 'SELECT CHROM FROM SV_PHENOTYPES WHERE PHENOTYPE = "%s"' % phenotype_str
        cur.execute(db_command)
        rows = cur.fetchall()
        chroms = set([r[0] for r in rows])

        # Get the SV data for each chromosome
        sv_data = {}
        for chrom in chroms:
            data_command =\
                'SELECT SV_START, SV_END FROM SV_PHENOTYPES WHERE PHENOTYPE = "%s" AND CHROM = "%s"'\
                % (phenotype_str, chrom)
            cur.execute(data_command)
            chrom_data = cur.fetchall()
            sv_data[chrom] = chrom_data

        # Add to the phenotype dictionary
        sv_phenotype_dict[phenotype_str] = sv_data

    conn.close()

    # Save histograms
    for phen_key in sv_phenotype_dict.keys():
        phen_data = sv_phenotype_dict[phen_key]
        for chrom in phen_data.keys():
            try:
                chrom_data = phen_data[chrom]
            except KeyError as e:
                print(e)
                print("Missing key: ", chrom)
                continue

            # Generate position counts
            genome_locs = []
            for start_pos, end_pos in chrom_data:
                sv_positions = list(range(start_pos, end_pos))
                genome_locs.extend(sv_positions)

            # Create and save the histogram
            #bin_size = max([1, round(math.sqrt(len(genome_locs)))])
            bin_size = 10
            plt.hist(genome_locs, bins=bin_size)
            plt.xlabel('Location in GRCh38')
            plt.ylabel('Count')

            title_label = 'Chromosome %s' %chrom
            plt.title(title_label)

            # Format the filepath and save the image
            img_dir = 'Data/'
            phen_label = phen_key.replace('/', '_')
            img_filepath = img_dir + '%s_Chr%s.png' % (phen_label, chrom)
            if not os.path.exists(img_dir):
                # Create a new directory if it does not exist
                os.makedirs(img_dir)

            plt.savefig(img_filepath)
            plt.close()

    print("Done.")


if __name__ == '__main__':
    db_filepath = r'sv_phenotypes.sqlite'
    generate_plots(db_filepath)
