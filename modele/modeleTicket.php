<?php

require_once __DIR__ . '/bd.php';

class ModeleTicket
{
    private const ETAPE_SQL = "CASE WHEN s.status_name = 'Nouveau' THEN 'ouvert'
                                    WHEN s.is_done = 1 THEN 'ferme'
                                    ELSE 'encours' END";

    public static function obtenirTicketsUtilisateur(int $idUtilisateur, string|null $etape = null)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT t.id_ticket, t.title, t.creation_date,
                    c.category_name, p.level_name AS priorite,
                    " . self::ETAPE_SQL . " AS etape
             FROM ticket t
             JOIN ticket_status s ON s.id_ticket_status = t.id_ticket_status
             JOIN priority p      ON p.id_priority = t.id_priority
             JOIN problem pb      ON pb.id_problem = t.id_problem
             JOIN problem_type pt ON pt.id_problem_type = pb.id_problem_type
             JOIN category c      ON c.id_category = pt.id_category
             WHERE t.id_user = :idUtilisateur
               AND (:etapeVide IS NULL OR " . self::ETAPE_SQL . " = :etape)
             ORDER BY t.creation_date DESC, t.id_ticket DESC"
        );

        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':etapeVide', $etape);
        $req->bindParam(':etape', $etape);

        $req->execute();

        return $req;
    }

    public static function obtenirTicketUtilisateur(int $idTicket, int $idUtilisateur)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT t.id_ticket, t.title, t.creation_date, pb.description,
                    c.id_category, c.category_name,
                    p.id_priority, p.level_name AS priorite,
                    " . self::ETAPE_SQL . " AS etape
             FROM ticket t
             JOIN ticket_status s ON s.id_ticket_status = t.id_ticket_status
             JOIN priority p      ON p.id_priority = t.id_priority
             JOIN problem pb      ON pb.id_problem = t.id_problem
             JOIN problem_type pt ON pt.id_problem_type = pb.id_problem_type
             JOIN category c      ON c.id_category = pt.id_category
             WHERE t.id_ticket = :idTicket AND t.id_user = :idUtilisateur"
        );

        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

        $req->execute();

        return $req;
    }

    public static function obtenirTousLesTickets(
        string|null $etape = null,
        int|null $idPriorite = null,
        int|null $idCategorie = null
    ) {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT t.id_ticket, t.title, t.creation_date,
                    u.first_name, u.last_name,
                    c.category_name, p.level_name AS priorite,
                    s.status_name AS statut_detail,
                    " . self::ETAPE_SQL . " AS etape
             FROM ticket t
             JOIN app_user u      ON u.id_user = t.id_user
             JOIN ticket_status s ON s.id_ticket_status = t.id_ticket_status
             JOIN priority p      ON p.id_priority = t.id_priority
             JOIN problem pb      ON pb.id_problem = t.id_problem
             JOIN problem_type pt ON pt.id_problem_type = pb.id_problem_type
             JOIN category c      ON c.id_category = pt.id_category
             WHERE (:etapeVide IS NULL OR " . self::ETAPE_SQL . " = :etape)
               AND (:prioriteVide IS NULL OR t.id_priority = :priorite)
               AND (:categorieVide IS NULL OR c.id_category = :categorie)
             ORDER BY t.creation_date DESC, t.id_ticket DESC"
        );

        $req->bindParam(':etapeVide', $etape);
        $req->bindParam(':etape', $etape);
        $req->bindParam(':prioriteVide', $idPriorite, PDO::PARAM_INT);
        $req->bindParam(':priorite', $idPriorite, PDO::PARAM_INT);
        $req->bindParam(':categorieVide', $idCategorie, PDO::PARAM_INT);
        $req->bindParam(':categorie', $idCategorie, PDO::PARAM_INT);

        $req->execute();

        return $req;
    }

    public static function obtenirTicketsParStatut(string $etape)
    {
        return self::obtenirTousLesTickets($etape, null, null);
    }

    public static function obtenirTicketsParPriorite(int $idPriorite)
    {
        return self::obtenirTousLesTickets(null, $idPriorite, null);
    }

    public static function obtenirTicketsParCategorie(int $idCategorie)
    {
        return self::obtenirTousLesTickets(null, null, $idCategorie);
    }

    public static function obtenirTicketTechnicien(int $idTicket)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT t.id_ticket, t.title, t.creation_date, pb.description,
                    u.id_user AS id_employe, u.first_name, u.last_name, u.email,
                    c.id_category, c.category_name,
                    p.id_priority, p.level_name AS priorite,
                    s.status_name AS statut_detail,
                    " . self::ETAPE_SQL . " AS etape,
                    (SELECT CONCAT(tu.first_name, ' ', tu.last_name)
                     FROM assignment a JOIN app_user tu ON tu.id_user = a.id_user
                     WHERE a.id_ticket = t.id_ticket AND a.end_date IS NULL
                     LIMIT 1) AS technicien_assigne
             FROM ticket t
             JOIN app_user u      ON u.id_user = t.id_user
             JOIN ticket_status s ON s.id_ticket_status = t.id_ticket_status
             JOIN priority p      ON p.id_priority = t.id_priority
             JOIN problem pb      ON pb.id_problem = t.id_problem
             JOIN problem_type pt ON pt.id_problem_type = pb.id_problem_type
             JOIN category c      ON c.id_category = pt.id_category
             WHERE t.id_ticket = :idTicket"
        );

        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);

        $req->execute();

        return $req;
    }

    public static function ajouterTicket(
        int $idUtilisateur,
        string $titre,
        string $description,
        int $idCategorie,
        int $idPriorite
    ) {
        $connexion = BD::ObtenirConnexion();

        $connexion->beginTransaction();

        try {
            $req = $connexion->prepare(
                "INSERT INTO problem (description, id_room, id_problem_type)
                 SELECT :description, NULL, id_problem_type
                 FROM problem_type
                 WHERE id_category = :idCategorie AND problem_name = 'Autre problème'"
            );
            $req->bindParam(':description', $description);
            $req->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
            $req->execute();

            if ($req->rowCount() !== 1) {
                throw new PDOException('Catégorie invalide.');
            }

            $idProbleme = (int) $connexion->lastInsertId();

            $req = $connexion->prepare(
                "INSERT INTO ticket (title, id_user, id_ticket_status, id_problem, id_priority)
                 SELECT :titre, :idUtilisateur, id_ticket_status, :idProbleme, :idPriorite
                 FROM ticket_status WHERE status_name = 'Nouveau'"
            );
            $req->bindParam(':titre', $titre);
            $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
            $req->bindParam(':idProbleme', $idProbleme, PDO::PARAM_INT);
            $req->bindParam(':idPriorite', $idPriorite, PDO::PARAM_INT);
            $req->execute();

            $idTicket = (int) $connexion->lastInsertId();

            $req = $connexion->prepare(
                "INSERT INTO history_ticket_status (id_user, id_ticket_status, id_ticket)
                 SELECT :idUtilisateur, id_ticket_status, :idTicket
                 FROM ticket_status WHERE status_name = 'Nouveau'"
            );
            $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
            $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
            $req->execute();

            $connexion->commit();

            return $idTicket;
        } catch (PDOException $e) {
            $connexion->rollBack();
            throw $e;
        }
    }

    public static function mettreAJourTicket(
        int $idTicket,
        int $idUtilisateur,
        string $titre,
        string $description
    ) {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "UPDATE ticket t
             JOIN ticket_status s ON s.id_ticket_status = t.id_ticket_status
             JOIN problem pb      ON pb.id_problem = t.id_problem
             SET t.title = :titre, pb.description = :description
             WHERE t.id_ticket = :idTicket
               AND t.id_user = :idUtilisateur
               AND s.is_done = 0"
        );

        $req->bindParam(':titre', $titre);
        $req->bindParam(':description', $description);
        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

        $req->execute();

        return $req->rowCount() > 0;
    }

    public static function changerEtapeTicket(int $idTicket, int $idTechnicien, string $etape)
    {
        $connexion = BD::ObtenirConnexion();

        $connexion->beginTransaction();

        try {
            if ($etape === 'encours') {
                $req = $connexion->prepare(
                    "SELECT COUNT(*) FROM assignment WHERE id_ticket = :idTicket AND end_date IS NULL"
                );
                $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
                $req->execute();

                if ((int) $req->fetchColumn() === 0) {
                    $req = $connexion->prepare(
                        "INSERT INTO assignment (start_date, id_ticket, id_user)
                         VALUES (NOW(), :idTicket, :idTechnicien)"
                    );
                    $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
                    $req->bindParam(':idTechnicien', $idTechnicien, PDO::PARAM_INT);
                    $req->execute();

                    self::ajouterHistorique($connexion, $idTicket, $idTechnicien, 'Assigné');
                }

                self::ajouterHistorique($connexion, $idTicket, $idTechnicien, 'En cours');
            } elseif ($etape === 'ferme' || $etape === 'ouvert') {
                $req = $connexion->prepare(
                    "UPDATE assignment SET end_date = NOW()
                     WHERE id_ticket = :idTicket AND end_date IS NULL"
                );
                $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
                $req->execute();

                self::ajouterHistorique(
                    $connexion,
                    $idTicket,
                    $idTechnicien,
                    $etape === 'ferme' ? 'Résolu' : 'Nouveau'
                );
            } else {
                throw new PDOException('Étape invalide.');
            }

            $connexion->commit();

            return true;
        } catch (PDOException $e) {
            $connexion->rollBack();
            throw $e;
        }
    }

    private static function ajouterHistorique(PDO $connexion, int $idTicket, int $idUtilisateur, string $nomStatut)
    {
        $req = $connexion->prepare(
            "INSERT INTO history_ticket_status (id_user, id_ticket_status, id_ticket)
             SELECT :idUtilisateur, id_ticket_status, :idTicket
             FROM ticket_status WHERE status_name = :nomStatut"
        );
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $req->bindParam(':nomStatut', $nomStatut);

        return $req->execute();
    }
}
