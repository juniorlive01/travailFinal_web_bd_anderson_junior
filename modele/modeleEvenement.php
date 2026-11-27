<?php

require_once __DIR__ . '/BD.php';

class ModeleEvenement
{
    public static function ajouterEvenement(
        int $idTicket,
        int $idUtilisateur,
        string $message,
        bool $estPrive = false
    ) {
        $message = trim($message);

        if ($message === '') {
            return 0;
        }

        $connexion = BD::ObtenirConnexion();

        $prive = $estPrive ? 1 : 0;

        $req = $connexion->prepare(
            "INSERT INTO event (message, is_private, id_user, id_ticket)
             SELECT :message, :prive, :idUtilisateur, t.id_ticket
             FROM ticket t
             WHERE t.id_ticket = :idTicket
               AND (t.id_user = :idProprietaire
                    OR EXISTS (SELECT 1 FROM technician WHERE id_user = :idTechnicien))
               AND (:priveVerif = 0
                    OR EXISTS (SELECT 1 FROM technician WHERE id_user = :idTechnicienPrive))"
        );

        $req->bindParam(':message', $message);
        $req->bindParam(':prive', $prive, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $req->bindParam(':idProprietaire', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':idTechnicien', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':priveVerif', $prive, PDO::PARAM_INT);
        $req->bindParam(':idTechnicienPrive', $idUtilisateur, PDO::PARAM_INT);

        $req->execute();

        if ($req->rowCount() !== 1) {
            return 0;
        }

        return (int) $connexion->lastInsertId();
    }


    public static function obtenirEvenementsUtilisateur(int $idTicket, int $idUtilisateur, int $apres = 0)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT e.id_event, e.date_creation, e.message, e.id_user,
                    u.first_name, u.last_name,
                    (tech.id_user IS NOT NULL) AS est_technicien
             FROM event e
             JOIN ticket t        ON t.id_ticket = e.id_ticket
             JOIN app_user u      ON u.id_user = e.id_user
             LEFT JOIN technician tech ON tech.id_user = e.id_user
             WHERE e.id_ticket = :idTicket
               AND t.id_user = :idUtilisateur
               AND e.is_private = 0
               AND e.id_event > :apres
             ORDER BY e.id_event ASC"
        );

        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':apres', $apres, PDO::PARAM_INT);

        $req->execute();

        return $req;
    }

    public static function obtenirEvenementsTechnicien(int $idTicket, int $apres = 0)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT e.id_event, e.date_creation, e.message, e.is_private, e.id_user,
                    u.first_name, u.last_name,
                    (tech.id_user IS NOT NULL) AS est_technicien
             FROM event e
             JOIN app_user u      ON u.id_user = e.id_user
             LEFT JOIN technician tech ON tech.id_user = e.id_user
             WHERE e.id_ticket = :idTicket
               AND e.id_event > :apres
             ORDER BY e.id_event ASC"
        );

        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $req->bindParam(':apres', $apres, PDO::PARAM_INT);

        $req->execute();

        return $req;
    }
}
