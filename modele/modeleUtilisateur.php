<?php
require_once 'modele/bd.php';
class ModeleUtilisateurs
{
    public static function obtenirUtilisateur(string $nom)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT id_user, last_name, first_name, phone, email, created_at, is_active, id_site
             FROM app_user
             WHERE last_name = :nom"
        );

        $req->bindParam(':nom', $nom);

        $req->execute();

        return $req;
    }

    public static function obtenirUtilisateurParNomEtRole(string $nom, string $role)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT u.id_user, u.last_name, u.first_name, u.phone, u.email,
                    u.created_at, u.is_active, u.id_site, r.role_name
             FROM app_user u
             JOIN app_user_role ur ON ur.id_user = u.id_user
             JOIN role r           ON r.id_role = ur.id_role
             WHERE u.last_name = :nom AND r.role_name = :role"
        );

        $req->bindParam(':nom', $nom);
        $req->bindParam(':role', $role);

        $req->execute();

        return $req;
    }

    public static function obtenirUtilisateurParCourriel(string $courriel)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT u.id_user, u.last_name, u.first_name, u.email, u.password_hash,
                    u.is_active, r.role_name
             FROM app_user u
             JOIN app_user_role ur ON ur.id_user = u.id_user
             JOIN role r           ON r.id_role = ur.id_role
             WHERE u.email = :courriel"
        );

        $req->bindParam(':courriel', $courriel);

        $req->execute();

        return $req;
    }

    public static function ajouterUtilisateur(
        string $nom,
        string $prenom,
        string $courriel,
        string $motDePasseHache
    ) {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "INSERT INTO app_user (last_name, first_name, phone, email, password_hash, id_site)
             VALUES (:nom, :prenom, NULL, :courriel, :motDePasse, NULL)"
        );

        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':courriel', $courriel);
        $req->bindParam(':motDePasse', $motDePasseHache);

        $req->execute();

        return (int) $connexion->lastInsertId();
    }

    public static function ajouterEmploye(int $idUtilisateur)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "INSERT INTO app_user_role (id_user, id_role, attribution_date)
             SELECT :idUtilisateur, id_role, NULL FROM role WHERE role_name = 'Utilisateur'"
        );
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->execute();

        $req = $connexion->prepare("INSERT INTO end_user (id_user) VALUES (:idUtilisateur)");
        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);

        return $req->execute();
    }

    public static function inscrireEmploye(
        string $nom,
        string $prenom,
        string $courriel,
        string $motDePasseHache
    ) {
        $connexion = BD::ObtenirConnexion();

        $connexion->beginTransaction();

        try {
            $idUtilisateur = self::ajouterUtilisateur($nom, $prenom, $courriel, $motDePasseHache);
            self::ajouterEmploye($idUtilisateur);

            $connexion->commit();

            return $idUtilisateur;
        } catch (PDOException $e) {
            $connexion->rollBack();
            throw $e;
        }
    }

    public static function mettreAJourUtilisateur(
        int $idUtilisateur,
        string $nom,
        string $prenom,
        string $courriel
    ) {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "UPDATE app_user
             SET last_name = :nom, first_name = :prenom, email = :courriel
             WHERE id_user = :idUtilisateur"
        );

        $req->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':courriel', $courriel);

        return $req->execute();
    }
}

