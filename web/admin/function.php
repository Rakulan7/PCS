<?php
function searchFunction($inputId, $searchUrl, $type) {
    $script = <<<HTML
<script>
    document.getElementById('$inputId').addEventListener('input', async function() {
        const inputValue = this.value;
        try {
            const response = await fetch('$searchUrl?q=' + inputValue);
            
            if (!response.ok) {
                throw new Error('La requête a échoué : ' + response.status);
            }

            const data = await response.json();

            let tableHTML = "<table class='table table-striped'><thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Numéro pays</th><th>Numéro téléphone</th><th>Status</th><th>Détails</th></tr></thead><tbody>";
            data.forEach(function(user) {
                let status;
                if ('$type' === 'bailleur') {
                    if (user["accepte"] == 1 && user["refusee"] == 0) {
                        status = "Accepté";
                    } else if ((user["accepte"] == 0 && user["refusee"] == 0) || (user["accepte"] == null && user["refusee"] == null)) {
                        status = "En attente";
                    } else if (user["accepte"] == 0 && user["refusee"] == 1) {
                        status = "Refusé";
                    } else {
                        status = " ";
                    }
                } else if ('$type' === 'voyageur') {
                    if (user["bloque"] == 1) {
                        status = "Bloqué";
                    } else {
                        status = "Validé";
                    }
                }

                tableHTML += "<tr>";
                tableHTML += "<td>" + user['nom'] + "</td>";
                tableHTML += "<td>" + user['prenom'] + "</td>";
                tableHTML += "<td>" + user['email'] + "</td>";
                tableHTML += "<td>" + user['pays_telephone'] + "</td>";
                tableHTML += "<td>" + user['numero_telephone'] + "</td>";
                tableHTML += "<td>" + status + "</td>";
                tableHTML += "<td><a href='bdetails.php?id=" + user['id'] + "' class='btn btn-primary'>Détails</a></td>";
                tableHTML += "</tr>";
            });
            tableHTML += "</tbody></table>";

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
