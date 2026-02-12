# API

Core entities:
- recipies
- ingredients
    - core / optional
    - substitutions
    - fridge items
    - cupboard staples
- instructions
- mesurements
- dietary requirements 
- category
- num servings


API structure
- POST recipies
- GET recipie data 
return
    - recipie ID
    - recipie name
    - recipie ingredients
    - use that to get recipie and instructions (and video if exists)


DB structure:
tblrecipies:
- recipieID 
    Primary Key, auto increment
- recipiename
- cookingtime
- favorites

tblingredients
- ingredientID
    primary key
- instorage
    e.g. refrigerated, cupboard, freezer...
- ingredientname
- staple
    bool: T or F

tbllinkrecipies
- recipieID
    foreign key => tblrecipies
    joint primary key
- ingredientID
    foreign key => tblingredients
    joint primary key
- quantperportion
- unit
- isoptional
    bool

tblinstructions
- recipieID
    forwign key => tblrecipies
    joint primary key
- instructionno
    joint primary key
- instruction

tbllinkreqs
- recipieID
    foreign key => tblrecipies
    joint primary key
- reqID
    joint primary key
    foreign key => tbldietryreqs

tbldietryreqs
- reqID
    primary key
- reqname

useringredients
- ingredientID
    foreignkey => tblingredients
    primary key
- offdate
