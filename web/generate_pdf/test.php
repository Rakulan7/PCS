<?php
require('fpdf186/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Paris Care Taker Services', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, '242 Rue du Faubourg Saint-Antoine, 75012 Paris', 0, 1, 'C');
        $this->Cell(0, 10, 'Telephone: 01 56 06 90 41', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function InvoiceTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(40, 6, $col, 1);
            }
            $this->Ln();
        }
    }
}

// Fonction pour récupérer la connexion à la base de données
function getDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pcs2";

    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }

    return $db;
}

// Connexion à la base de données
try {
    $db = getDatabase();
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Récupération des bailleurs/prestataires disponibles
$users_result = $db->query("SELECT id_utilisateur FROM utilisateur WHERE bailleur_accept = 1 OR prestataire_accept = 1");

if (!$users_result) {
    die("Query failed: " . $db->error);
}

// Génération des factures pour chaque bailleur/prestataire
while ($user = $users_result->fetch_assoc()) {
    $id_utilisateur = $user['id_utilisateur'];

    // Récupération des informations de l'utilisateur à partir de la base de données
    $user_result = $db->query("SELECT * FROM utilisateur WHERE id_utilisateur = $id_utilisateur");

    if (!$user_result) {
        die("Query failed: " . $db->error);
    }

    $user_info = $user_result->fetch_assoc();

    if (!$user_info) {
        die("User not found");
    }

    // Récupération des prestations commandées par l'utilisateur pour le mois en cours
    $current_month = date('Y-m-01'); // Premier jour du mois en cours
    $prestations_result = $db->query("
        SELECT p.titre, p.montant, p.description, pc.montant AS total, pc.debut_prestation, pc.fin_prestation
        FROM prestation_commande pc
        JOIN prestation p ON pc.id_prestation = p.id_prestation
        WHERE pc.id_utilisateur = $id_utilisateur
        AND pc.debut_prestation >= '$current_month'
    ");

    if (!$prestations_result) {
        die("Query failed: " . $db->error);
    }

    // Génération du PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    // Informations de l'utilisateur
    $pdf->Cell(0, 10, 'Facture pour: ' . $user_info['nom'] . ' ' . $user_info['prenom'], 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(10);

    // Tableau des prestations
    $header = array('Titre', 'Debut', 'Fin', 'Montant', 'Total');
    $data = [];
    $total_facture = 0;

    while ($row = $prestations_result->fetch_assoc()) {
        $data[] = array($row['titre'], $row['debut_prestation'], $row['fin_prestation'], number_format($row['montant'], 2), number_format($row['total'], 2));
        $total_facture += $row['total'];
    }

    $pdf->InvoiceTable($header, $data);

    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(120, 6, '', 0);
    $pdf->Cell(40, 6, 'Total', 1);
    $pdf->Cell(40, 6, number_format($total_facture, 2), 1);

    // Génération du fichier PDF 
    $pdf_file = "/var/www/facture/{$id_utilisateur}_" . date('Ymd_His') . "_" . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT) . ".pdf";
    $pdf->Output('F', $pdf_file);

    echo "Facture générée avec succès pour l'utilisateur {$id_utilisateur}: <a href='$pdf_file' target='_blank'>Télécharger la facture</a><br>";
}

?>
