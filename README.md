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
        if cooking time > 24 hours, convert to days when displayed
        stored in minutes
    - favorites
    - imagepath

    tblingredients
    - ingredientID
        primary key
    - storageID
        foreign key => tblstorage
    - ingredientname
    - staple
        bool: T or F

    tblstorage
    - storageID
        primary key
    - storagetype
        e.g. refrigerated, cupboard, freezer...

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
    - userID
        foreign key => tblusers
    - ingredientID
        foreignkey => tblingredients
        primary key
    - offdate

    tblusers
    - userID    
        primary key
    - username
    - email
    - passwordhash



Page structure:
- login / create account
- home
    goes to add/edit ingredients, see recipies, favorites, and create recipies
- edit ingreditnts
    can add/ edit/ delete/ update quantity
- see recipies
    generates recipies
    can select the ingredients or add new ones
- favorites
    favorite recipies
- create recipies
    create and upload recipies