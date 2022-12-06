
# To generate a table in python
def sumtab (phenotype):
    import sqlite3
    import os
    import sys
    import pandas as pd
    
    if os.path.isfile('summary_table.csv'): #check if file already exists. If it does, then if statement 
        # removes it
        os.remove('summary_table.csv')

    # connect the sqlite and perform an query on sqlite database file. Replace URL with URL with sqlite database
    conn = sqlite3.connect("sv_phenotypes.sqlite")
    cur = conn.cursor()
    cur.execute('SELECT CHROM, SV_START, SV_END, PHENOTYPE FROM sv_phenotypes WHERE phenotype=?', [phenotype]) # filters through the databased according to the input phenotype from the php.
    filter = cur.fetchall() # fetch the filtered database
    # converts to the dataframe
    data_frame = pd.DataFrame(filter, columns = ['Chromosome', 'Start', 'End', 'Phenotype'])
	
	# Add hist.
	
    print(data_frame) # print the dataframe from the php. REMOVE LATER
    data_frame.to_csv('summary_table.csv')

    cur.commit()
    
    cur.close() 
