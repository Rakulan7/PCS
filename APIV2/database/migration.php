<?php

require_once __DIR__ . "/connection.php";

try {
    $databaseConnection = getDatabaseConnection();

    $queries = [
        "DROP TABLE IF EXISTS facture;",
        "DROP TABLE IF EXISTS habilitation;",
        "DROP TABLE IF EXISTS paiement_abonnement;",
        "DROP TABLE IF EXISTS prestation;",
        "DROP TABLE IF EXISTS fiche_intervention;",
        "DROP TABLE IF EXISTS intervention;",
        "DROP TABLE IF EXISTS prestataire;",
        "DROP TABLE IF EXISTS devis;",
        "DROP TABLE IF EXISTS abonnement_voyageur;",
        "DROP TABLE IF EXISTS etat_des_lieux;",
        "DROP TABLE IF EXISTS photo;",
        "DROP TABLE IF EXISTS abonnement;",
        "DROP TABLE IF EXISTS occupation;",
        "DROP TABLE IF EXISTS bien;",
        "DROP TABLE IF EXISTS administrateur;",
        "DROP TABLE IF EXISTS voyageur;",
        "DROP TABLE IF EXISTS bailleur;",

        "CREATE TABLE bailleur(
           id_bailleur INT AUTO_INCREMENT,
           nom VARCHAR(50),
           prenom VARCHAR(50),
           email VARCHAR(255),
           mot_passe VARCHAR(70),
           date_inscription DATE,
           date_naissance DATE,
           numero_telephone CHAR(10),
           pays_telephone VARCHAR(10),
           bloque BOOLEAN,
           supprime DATE,
           code_banque SMALLINT,
           code_guichet SMALLINT,
           numero_compte INT,
           cle_rib BYTE,
           iban INT,
           bic_swift VARCHAR(50),
           url_rib VARCHAR(255),
           PRIMARY KEY(id_bailleur)
        );",

        "CREATE TABLE voyageur(
           id_voyageur INT AUTO_INCREMENT,
           nom VARCHAR(50),
           prenom VARCHAR(50),
           email VARCHAR(255),
           mot_passe VARCHAR(70),
           date_inscription DATE,
           date_naissance DATE,
           numero_telephone CHAR(10),
           pays_telephone VARCHAR(10),
           bloque BOOLEAN,
           supprime DATE,
           PRIMARY KEY(id_voyageur)
        );",

        "CREATE TABLE administrateur(
           id_administrateur INT AUTO_INCREMENT,
           fonction VARCHAR(50),
           PRIMARY KEY(id_administrateur)
        );",

        "CREATE TABLE bien(
           id_bien INT AUTO_INCREMENT,
           refuse_par_admin BOOLEAN,
           raison_refuse TEXT,
           numero_rue INT,
           type_rue VARCHAR(50),
           rue VARCHAR(255),
           ville VARCHAR(50),
           code_postal INT,
           pays VARCHAR(50),
           titre VARCHAR(50),
           description TEXT,
           nombre_chambre INT,
           nombre_salle_de_bain INT,
           nombre_toilette INT,
           prix DECIMAL(15,2),
           taille DECIMAL(9,2),
           id_administrateur INT NOT NULL,
           id_bailleur INT NOT NULL,
           PRIMARY KEY(id_bien),
           FOREIGN KEY(id_administrateur) REFERENCES administrateur(id_administrateur),
           FOREIGN KEY(id_bailleur) REFERENCES bailleur(id_bailleur)
        );",

        "CREATE TABLE Occupation(
           id_occupation INT AUTO_INCREMENT,
           date_debut DATE,
           date_fin DATE,
           raison_indispo TEXT,
           montant DECIMAL(15,2),
           nombre_personne BYTE,
           id_bailleur INT NOT NULL,
           id_voyageur INT NOT NULL,
           id_bien INT NOT NULL,
           PRIMARY KEY(id_occupation),
           FOREIGN KEY(id_bailleur) REFERENCES bailleur(id_bailleur),
           FOREIGN KEY(id_voyageur) REFERENCES voyageur(id_voyageur),
           FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
        );",

        "CREATE TABLE abonnement(
           id_abonnement INT AUTO_INCREMENT,
           titre VARCHAR(50),
           description TEXT,
           id_bailleur INT NOT NULL,
           PRIMARY KEY(id_abonnement),
           FOREIGN KEY(id_bailleur) REFERENCES bailleur(id_bailleur)
        );",

        "CREATE TABLE photo(
           id_photo BOOLEAN AUTO_INCREMENT,
           url VARCHAR(255),
           id_bien INT NOT NULL,
           PRIMARY KEY(id_photo),
           FOREIGN KEY(id_bien) REFERENCES bien(id_bien)
        );",

        "CREATE TABLE etat_des_lieux(
           id_etat INT AUTO_INCREMENT,
           date_etat DATE,
           url VARCHAR(255),
           id_occupation INT NOT NULL,
           PRIMARY KEY(id_etat),
           FOREIGN KEY(id_occupation) REFERENCES Occupation(id_occupation)
        );",

        "CREATE TABLE abonnement_voyageur(
           id_abonnement INT AUTO_INCREMENT,
           date_debut DATE,
           date_fin DATE,
           id_voyageur INT NOT NULL,
           PRIMARY KEY(id_abonnement),
           FOREIGN KEY(id_voyageur) REFERENCES voyageur(id_voyageur)
        );",

        "CREATE TABLE devis(
           id_devis INT AUTO_INCREMENT,
           url_devis VARCHAR(255),
           date_demande DATE,
           id_voyageur INT NOT NULL,
           PRIMARY KEY(id_devis),
           FOREIGN KEY(id_voyageur) REFERENCES voyageur(id_voyageur)
        );",

        "CREATE TABLE prestataire(
           id_prestataire INT AUTO_INCREMENT,
           refuse_par_admin BOOLEAN,
           raison_refuse TEXT,
           nom VARCHAR(50),
           prenom VARCHAR(50),
           email VARCHAR(255),
           mot_passe VARCHAR(70),
           id_administrateur INT NOT NULL,
           PRIMARY KEY(id_prestataire),
           FOREIGN KEY(id_administrateur) REFERENCES administrateur(id_administrateur)
        );",

        "CREATE TABLE intervention(
           id_intervention INT AUTO_INCREMENT,
           date_debut_intervention DATE,
           date_fin_intervention DATE,
           raison CHAR(255),
           description TEXT,
           id_bien INT NOT NULL,
           id_prestataire INT NOT NULL,
           PRIMARY KEY(id_intervention),
           FOREIGN KEY(id_bien) REFERENCES bien(id_bien),
           FOREIGN KEY(id_prestataire) REFERENCES prestataire(id_prestataire)
        );",

        "CREATE TABLE fiche_intervention(
           id_fiche INT AUTO_INCREMENT,
           url CHAR(255),
           id_intervention INT NOT NULL,
           PRIMARY KEY(id_fiche),
           FOREIGN KEY(id_intervention) REFERENCES intervention(id_intervention)
        );",

        "CREATE TABLE prestation(
           id_prestation INT AUTO_INCREMENT,
           evaluation BYTE,
           url_fiche VARCHAR(255),
           montant DECIMAL(15,2),
           debut_prestation DATE,
           duree_jour INT,
           fin_prestation DATE,
           id_prestataire INT NOT NULL,
           id_voyageur INT NOT NULL,
           PRIMARY KEY(id_prestation),
           FOREIGN KEY(id_prestataire) REFERENCES prestataire(id_prestataire),
           FOREIGN KEY(id_voyageur) REFERENCES voyageur(id_voyageur)
        );",

        "CREATE TABLE paiement_abonnement(
           id_paiement INT AUTO_INCREMENT,
           date_paiement DATE,
           paiement_valide BOOLEAN,
           paiement_methode VARCHAR(50),
           montant DECIMAL(15,2),
           id_abonnement INT NOT NULL,
           id_occupation INT NOT NULL,
           id_prestation INT NOT NULL,
           id_abonnement_1 INT NOT NULL,
           PRIMARY KEY(id_paiement),
           FOREIGN KEY(id_abonnement) REFERENCES abonnement(id_abonnement),
           FOREIGN KEY(id_occupation) REFERENCES Occupation(id_occupation),
           FOREIGN KEY(id_prestation) REFERENCES prestation(id_prestation),
           FOREIGN KEY(id_abonnement_1) REFERENCES abonnement_voyageur(id_abonnement)
        );",

        "CREATE TABLE habilitation(
           id_habilitation INT AUTO_INCREMENT,
           nom VARCHAR(50),
           description TEXT,
           url VARCHAR(255),
           valide_par_admin BOOLEAN,
           id_prestataire INT NOT NULL,
           PRIMARY KEY(id_habilitation),
           FOREIGN KEY(id_prestataire) REFERENCES prestataire(id_prestataire)
        );",

        "CREATE TABLE facture(
           id_facture INT AUTO_INCREMENT,
           url VARCHAR(255),
           id_prestataire INT NOT NULL,
           PRIMARY KEY(id_facture),
           FOREIGN KEY(id_prestataire) REFERENCES prestataire(id_prestataire)
        );"
    ];

    // Exécution des requêtes SQL
    foreach ($queries as $query) {
        $databaseConnection->query($query);
    }

    echo "Migration réussie" . PHP_EOL;
} catch (Exception $exception) {
    echo "Une erreur est survenue durant la migration des données" . PHP_EOL;
    echo $exception->getMessage();
}
