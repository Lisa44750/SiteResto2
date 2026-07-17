<?php

namespace modele\dao;

use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of AimerDAO
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class AimerDAO {

    /**
     * Vérifie si un restaurant est "aimé" d'un utilisateur
     * @param int $idR identifiant du restaurant concerné
     * @param int $idU identifiant de l'utilisateur concerné
     * @return bool =true si "aimé", = false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function estAimeById(int $idU, int $idR): bool {
        $retour = false;
        try {
            $requete = "SELECT * FROM aimer WHERE idR=:idR AND idU=:idU";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                $retour = true;
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::estAimeByIdU : <br/>" . $e->getMessage());
        }
        return $retour;
    }

    /**
     * Ajouter un couple (idU, idR) à la table aimer
     * @param int $idU identifiant de l'utilisateur qui aime le restaurant
     * @param int $idR identifiant du restaurant aimé
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function insert(int $idU, int $idR): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("INSERT INTO aimer (idU, idR) VALUES(:idU,:idR)");
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insert : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

    /**
     * Suppimer un couple (idU, idR) de la table aimer
     * @param int $idU identifiant de l'utilisateur
     * @param int $idR identifiant du restaurant
     * @return bool true si réussite, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function delete(int $idU, int $idR): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("DELETE FROM aimer WHERE idR=:idR and idU=:idU");
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::delete : <br/>" . $e->getMessage());
        }
        return $resultat;
    }
    
    
    /*public static function typeCuisineAimeById(int $idU): array {
        $retour = array();
        try {
            $requete = "SELECT libelle from typecuisine
                        inner join typecuisinef on typecuisine.id = typecuisinef.id
                        inner join utilisateur on utilisateur.idU = typecuisinef.idU
                        where typecuisinef.idU = :idU;";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            
            
            
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                // Extraire l'enregistrement obtenu
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                //Instancier un nouveau restaurant
                $retour[] = $enreg;
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::typeCuisineAimeById : <br/>" . $e->getMessage());
        }
        return $retour;
    }*/
    
    
    public static function insertTypeCuisinePrefere(int $idU, int $id): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("INSERT INTO typecuisinef (idU, id) VALUES(:idU,:id)");
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idR, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insertTypeCuisinePrefere : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

    public static function deleteTypeCuisinePrefere(int $idU, int $id): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("DELETE FROM typecuisinef WHERE idU=:idU and id=:id  ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::deleteTypeCuisinePrefere : <br/>" . $e->getMessage());
        }
        return $resultat;
    }
}
