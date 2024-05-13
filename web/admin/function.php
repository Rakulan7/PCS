<?php
function searchFunction($inputId, $searchUrl) {
    $script = <<<HTML
<script>
    document.getElementById('$inputId').addEventListener('input', async function() {
        // Récupérer la valeur du champ input
        const inputValue = this.value; // "this" fait référence à l'élément sur lequel l'événement est déclenché
        console.log(inputValue);
        try {
            // Effectuer une requête Fetch
            const response = await fetch('$searchUrl?q=' + inputValue);
            
            if (!response.ok) {
                throw new Error('La requête a échoué : ' + response.status);
            }

            // Convertir la réponse en JSON
            const data = await response.json();

            // Construire le contenu HTML pour le tableau des résultats de la recherche
            let tableHTML = "<table class='table table-striped'><thead><tr><th>Nom</th><th>Prenom</th><th>Email</th><th>Numéro pays</th><th>Numéro téléphone</th><th>Status</th><th>Détails</th></tr></thead><tbody>";
            data.forEach(function(bailleur) {
                if (bailleur["accepte"] == 1 && bailleur["refusee"] == 0) {
                    status = "Accepté";
                } else if ((bailleur["accepte"] == 0 && bailleur["refusee"] == 0) || (bailleur["accepte"] == null && bailleur["refusee"] == null)) {
                    status = "En attente";
                } else if (bailleur["accepte"] == 0 && bailleur["refusee"] == 1) {
                    status = "Refusé";
                } else {
                    status = "";
                }
                tableHTML += "<tr>";
                tableHTML += "<td>" + bailleur['nom'] + "</td>";
                tableHTML += "<td>" + bailleur['prenom'] + "</td>";
                tableHTML += "<td>" + bailleur['email'] + "</td>";
                tableHTML += "<td>" + bailleur['pays_telephone'] + "</td>";
                tableHTML += "<td>" + bailleur['numero_telephone'] + "</td>";
                tableHTML += "<td>" + status + "</td>";
                tableHTML += "<td><a href='bdetails.php?id=" + bailleur['id_bailleur'] + "' class='btn btn-primary'>Détails</a></td>";
                tableHTML += "</tr>";
            });
            tableHTML += "</tbody></table>";

            // Afficher le tableau dans une div ayant l'id "searchResults"
            document.getElementById('searchResults').innerHTML = tableHTML;
        } catch (error) {
            console.error('Une erreur s\'est produite:', error);
        }
    });
</script>
HTML;
    echo $script;
}
?>
