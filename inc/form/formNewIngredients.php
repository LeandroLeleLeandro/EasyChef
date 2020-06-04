<?php
/*
*     Auteur              :  RUSSOTTI Leandro.
*     Projet              :  EasyChef.
*     Page                :  Formulaire d'ajout d'ingrédients.
*     Date début projet   :  25.05.2020.
*/
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="shadow-lg card text-dark" style="background-color: #EEEEEE;">
                <div class="card-header text-light p-3 pl-4" style="background-color: #453823; color: white;"><h4>Ajouter un ingrédient à la recette : <?= getNameOfRecipe($idRecipe); ?><span class="float-right"><button class="btn btn-success" onclick="showFormIngredients()">+</button>&nbsp;<button  class="btn btn-danger" onclick="hideFormIngredients()">-</button></span></h4></div>
                <div class="card-body p-0 m-0" id="divAddIngredients">
                    <form method="post">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom ingrédient</th>
                                    <th>Quantité ingrédient</th>
                                    <th>Unité ingrédient<small> (Facultatif)</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input required type="text" class="form-control" name="newIngredient"></td>
                                    <td><input required type="number" class="form-control" name="newQuantity"></td>
                                    <td><input type="text" class="form-control" name="newUnity"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><input type="submit" class="form-control btn btn-bouton1" value="Ajouter ingrédient" name="btnAddIngredient"></td>
                                </tr>
                            </tbody>
                        </table class="table">                         
                    </form>             
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showFormIngredients()
    {
        document.getElementById("divAddIngredients").style.display = "block";
    }

    function hideFormIngredients()
    {
        document.getElementById("divAddIngredients").style.display = "none";
    }
</script>
                                    