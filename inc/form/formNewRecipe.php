<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'ajout de recette.
*     Date début projet   :  25.05.2020.
*/

// Variable qui se crée a l'appuie du bouton.
$btnNewRecipe = FILTER_INPUT(INPUT_POST,"btnNewRecipe");
$idUser = filter_input(INPUT_GET,"user",FILTER_VALIDATE_INT);

// Lance le script a l'appuie du bouton.
if($btnNewRecipe)
{
    // Crée les variables
    $error = [];
    $titleRecipe = filter_input(INPUT_POST,"titleRecipe",FILTER_SANITIZE_STRING);
    $timeRequired = filter_input(INPUT_POST,"timeRequired",FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST,"description",FILTER_SANITIZE_STRING);
    $nbIngredient = filter_input(INPUT_POST,"hiddenNbIngredient",FILTER_VALIDATE_INT);
    $havePicture = false;

    $folder = 'img/upload/';                                            // Chemin ou seront uplaod les images
    $maximumSize = 3000000;                                             // Tailles max en octet
    $extensions = array('.png','.jpg','.jpeg');// Formats acceptés

    if($_FILES["picture"]["error"] != 4) 
    {
        $havePicture = true;
        $filename = $_FILES['picture']['name'];                             // Nom de l'image
        $extension = strrchr($filename, '.');                               // Extension de l'image
        $size = filesize($_FILES['picture']['tmp_name']);                   // Taille en octet de l'image     

        $pictureName = $titleRecipe.$extension;
        // Vérifie si l'extension est bonne.
        if(!in_array($extension, $extensions)) 
        {
            $error["picture"] = "Le fichier doit être de type png, jpg ou jpeg";
        }

        // Vérifie si la taille de l'image n'est pas trop haute.
        if($size>$maximumSize)
        {
            $error["picture"] = "La taille du fichier est trop grande";
        }   

    }
    else
    {
        $pictureName = "basepicture.jpg";    
    }
    
    
    // Continue si il n'y a aucune érreur.
    if (count($error) == 0)
    {  
        $lastId = insertNewRecipe($idUser,$titleRecipe,$description,$timeRequired); 
        if ($havePicture) 
        {
            // Uploads les fichier si la fonction renvoie TRUE.
            if(move_uploaded_file($_FILES['picture']['tmp_name'], $folder ."pictureN".$lastId.$extension)) 
            {         
                  
                insertNewPicture($lastId,"pictureN".$lastId.$extension);
                // Récuperer les ingrédients
                for ($i=0; $i <$nbIngredient ; $i++) 
                { 
                    $name = filter_input(INPUT_POST,"nameIngredient".($i+1),FILTER_SANITIZE_STRING);
                    $quantity = filter_input(INPUT_POST,"quantityIngredient".($i+1),FILTER_VALIDATE_INT);
                    $unity = filter_input(INPUT_POST,"unityIngredient".($i+1),FILTER_SANITIZE_STRING);

                    if ($unity) 
                    {
                        insertNewIngredients($lastId,$name,$quantity,$unity);
                    }
                    else
                    {
                        insertNewIngredients($lastId,$name,$quantity);
                    }
                    
                }
            }

            // Affiche les erreurs si elle renvoie FALSE.
            else 
            {      
                $error["picture"] = "Echec de l'upload";
            }
        }
        else
        {
            $lastId = insertNewRecipe($idUser,$titleRecipe,$description,$timeRequired);   
            insertNewPicture($lastId,$pictureName);
            // Récuperer les ingrédients
            for ($i=0; $i <$nbIngredient ; $i++) 
            { 
                $name = filter_input(INPUT_POST,"nameIngredient".($i+1),FILTER_SANITIZE_STRING);
                $quantity = filter_input(INPUT_POST,"quantityIngredient".($i+1),FILTER_VALIDATE_INT);
                $unity = filter_input(INPUT_POST,"unityIngredient".($i+1),FILTER_SANITIZE_STRING);

                if ($unity) 
                {
                    insertNewIngredients($lastId,$name,$quantity,$unity);
                }
                else
                {
                    insertNewIngredients($lastId,$name,$quantity);
                }
                
            }
        }
        echo '<meta http-equiv="refresh" content="0">';
        exit;
    }
    else
    {
        $error["recipe"] = "Erreur dans le formulaire";
    }
}
?>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <?php if (isset($error["recipe"])): ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #A52A2A"><h4><?php if(isset($error["recipe"])){ echo $error["recipe"];} ?></h4></div>
                <?php else: ?>
                    <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Ajouter une recette</h4></div>
                <?php endif; ?>
                <div class="card-body" id="divAddRecipe">
                    <form  enctype="multipart/form-data" method="post">
                    <input type="hidden" name="hiddenNbIngredient" id="hiddenNbIngredient" value="1">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label><h5>Titre de la recette :</h5></label>
                                    <?php if (isset($error["titleRecipe"])): ?>
                                        <input type="text" class="form-control is-invalid" name="titleRecipe" required>
                                        <div class="invalid-feedback"><?php if(isset($error["pseudo"])){ echo $error["pseudo"];} ?></div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" name="titleRecipe" required value="<?php if(isset($titleRecipe)){echo $titleRecipe;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label><h5>Temps nécessaire : <small>(en minutes)</small></h5></label>
                                    <?php if (isset($error["timeRequired"])): ?>
                                        <input type="number" class="form-control is-invalid" name="timeRequired" required>
                                        <div class="invalid-feedback"><?php if(isset($error["timeRequired"])){ echo $error["timeRequired"];} ?></div>
                                    <?php else: ?>
                                        <input type="number" class="form-control" name="timeRequired" required value="<?php if(isset($timeRequired)){echo $timeRequired;}?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label><h5>Marche à suivre :</h5></label>
                                    <?php if (isset($error["description"])): ?>
                                        <textarea class="form-control is-invalid" name="description"></textarea>
                                        <div class="invalid-feedback"><?php if(isset($error["description"])){ echo $error["description"];} ?></div>
                                    <?php else: ?>
                                        <textarea class="form-control" name="description"><?php if(isset($description)){echo $description;}?></textarea>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label><h5>Ingrédients : <button class="btn btn-success" onclick="addIngredients()">+</button><button  class="btn btn-danger" onclick="removeIngredients()">-</button></h5></label>
                                </div>
                                <div class="container-fluid p-0 m-0 row" id="divIngredients"> 
                                    <div class="col-lg-4 mb-4"><label><h5>Nom</h5></label><input type="text" class="form-control" name="nameIngredient1" required=""></div>
                                    <div class="col-lg-4 mb-4"><label><h5>Quantité</h5></label><input type="number" class="form-control" name="quantityIngredient1" required=""></div>
                                    <div class="col-lg-4 mb-4"><label><h5>Unité <small>(Facultatif) (gramme etc...)</small></h5></label><input type="text" class="form-control" name="unityIngredient1"></div>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label><h5>Photo de la recette : <small>(facultatif) </small><span class="text-danger"><?php if(isset($error["picture"])){ echo $error["picture"];} ?></span></h5></label>
                                    <input type="file" class="form-control-file" name="picture">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" class="form-control btn btn-bouton1" value="Poster la recette" name="btnNewRecipe">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var nbr = document.getElementById("hiddenNbIngredient").value;

function addIngredients()
{
    nbr++;
    var container = document.getElementById("divIngredients");
    while (container.hasChildNodes()) 
    {
        container.removeChild(container.lastChild);
    }
    for (i=0;i<nbr;i++)
    {
        // Création de la div + classes
        var divName = container.appendChild(document.createElement("div"));
        divName.classList.add("col-lg-4");
        divName.classList.add("mb-4");
        // Création du label + style
        var labelName = divName.appendChild(document.createElement("label"));
        var h5Name = labelName.appendChild(document.createElement("h5"));
        h5Name.innerHTML = "Nom";
        // Création de l'input + classes
        var inputName = document.createElement("input");
        inputName.type = "text";
        inputName.classList.add("form-control");
        inputName.name = "nameIngredient"+(i+1);
        inputName.required = true;
        divName.appendChild(inputName);

        // Création de la div + classes
        var divQuantity = container.appendChild(document.createElement("div"));
        divQuantity.classList.add("col-lg-4");
        divQuantity.classList.add("mb-4");
        // Création du label + style
        var labelQuantity = divQuantity.appendChild(document.createElement("label"));
        var h5Quantity = labelQuantity.appendChild(document.createElement("h5"));
        h5Quantity.innerHTML = "Quantité";
        // Création de l'input + classes
        var inputQuantity = document.createElement("input");
        inputQuantity.type = "number";
        inputQuantity.classList.add("form-control");
        inputQuantity.name = "quantityIngredient"+(i+1);
        inputQuantity.required = true;
        divQuantity.appendChild(inputQuantity);

        // Création de la div + classes
        var divUnity = container.appendChild(document.createElement("div"));
        divUnity.classList.add("col-lg-4");
        divUnity.classList.add("mb-4");
        // Création du label + style
        var labelUnity = divUnity.appendChild(document.createElement("label"));
        var h5Unity = labelUnity.appendChild(document.createElement("h5"));
        h5Unity.innerHTML = "Unité <small>(Facultatif) (gramme etc...)</small>";
        // Création de l'input + classes
        var inputUnity = document.createElement("input");
        inputUnity.type = "text";
        inputUnity.classList.add("form-control");
        inputUnity.name = "unityIngredient"+(i+1);
        divUnity.appendChild(inputUnity);
    }
    document.getElementById("hiddenNbIngredient").value = nbr;
}

function removeIngredients()
{
    if (nbr > 1) {
        nbr--;
    }
    var container = document.getElementById("divIngredients");
    while (container.hasChildNodes()) 
    {
        container.removeChild(container.lastChild);
    }
    for (i=0;i<nbr;i++)
    {
         // Création de la div + classes
         var divName = container.appendChild(document.createElement("div"));
        divName.classList.add("col-lg-4");
        divName.classList.add("mb-4");
        // Création du label + style
        var labelName = divName.appendChild(document.createElement("label"));
        var h5Name = labelName.appendChild(document.createElement("h5"));
        h5Name.innerHTML = "Nom";
        // Création de l'input + classes
        var inputName = document.createElement("input");
        inputName.type = "text";
        inputName.classList.add("form-control");
        inputName.name = "nameIngredient"+(i+1);
        inputName.required = true;
        divName.appendChild(inputName);

        // Création de la div + classes
        var divQuantity = container.appendChild(document.createElement("div"));
        divQuantity.classList.add("col-lg-4");
        divQuantity.classList.add("mb-4");
        // Création du label + style
        var labelQuantity = divQuantity.appendChild(document.createElement("label"));
        var h5Quantity = labelQuantity.appendChild(document.createElement("h5"));
        h5Quantity.innerHTML = "Quantité";
        // Création de l'input + classes
        var inputQuantity = document.createElement("input");
        inputQuantity.type = "number";
        inputQuantity.classList.add("form-control");
        inputQuantity.name = "quantityIngredient"+(i+1);
        inputQuantity.required = true;
        divQuantity.appendChild(inputQuantity);

        // Création de la div + classes
        var divUnity = container.appendChild(document.createElement("div"));
        divUnity.classList.add("col-lg-4");
        divUnity.classList.add("mb-4");
        // Création du label + style
        var labelUnity = divUnity.appendChild(document.createElement("label"));
        var h5Unity = labelUnity.appendChild(document.createElement("h5"));
        h5Unity.innerHTML = "Unité <small>(Facultatif) (gramme etc...)</small>";
        // Création de l'input + classes
        var inputUnity = document.createElement("input");
        inputUnity.type = "text";
        inputUnity.classList.add("form-control");
        inputUnity.name = "unityIngredient"+(i+1);
        divUnity.appendChild(inputUnity);
    }
    document.getElementById("hiddenNbIngredient").value = nbr;
}
</script>