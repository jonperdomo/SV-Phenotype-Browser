#!/usr/bin/env python
# coding: utf-8

# In[ ]:


# Import module
from tkinter import *
  

dropdown = Tk()
dropdown.title("Phenotype GUI")
  
# Adjust size
dropdown.geometry( "600x600" )

# Change the label text
def show():
    label.config( text = clicked.get() )
  
# Dropdown menu options
options = [
    "No",
    "Yes"
]
  
# datatype of menu text
clicked = StringVar()
  
# initial menu text
clicked.set( "No" )
  
# Create Dropdown menu
drop = OptionMenu( dropdown , clicked , *options )
drop.pack()
  
# Create button, it will change label text
button = Button( dropdown , text = "Submit" , command = show ).pack()
  
# Create Label
label = Label( dropdown , text = "Select phenotype of interest " )
label.pack()
  
# Execute tkinter
dropdown.mainloop()


# In[ ]:




