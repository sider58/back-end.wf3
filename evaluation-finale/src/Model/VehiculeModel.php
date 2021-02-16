<?php

namespace App\Model;

use App\Core\AbstractModel;

class VehiculeModel extends AbstractModel
{
    public function getAll()
    {
        $sql = 'SELECT id_vehicule, marque, modele, couleur, immatriculation
                FROM vehicule
                ORDER BY marque';

        return $this->database->selectAll($sql);
    }

    public function getOne(int $idVehicule)
    {
        $sql = 'SELECT id_vehicule, marque, modele, couleur, immatriculation
                FROM vehicule
                WHERE id_vehicule = ?';

        return $this->database->selectOne($sql, [$idVehicule]);
    }

    public function insert(string $marque, string $modele, string $couleur, string $immatriculation)
    {
        $sql = 'INSERT INTO vehicule (marque, modele, couleur, immatriculation)
                VALUES (?,?,?,?)';

        $this->database->prepareAndExecuteQuery($sql, [$marque, $modele, $couleur, $immatriculation]);
    }

    public function update(string $marque, string $modele, string $couleur, string $immatriculation, int $idVehicule)
    {
        $sql = 'UPDATE vehicule SET marque = ?, modele = ?, couleur = ?, immatriculation = ? WHERE id_vehicule = ?';

        $this->database->prepareAndExecuteQuery($sql, [$marque, $modele, $couleur, $immatriculation, $idVehicule]);
    }

    public function delete(int $idVehicule)
    {
        $sql = 'DELETE FROM vehicule WHERE id_vehicule = ?';

        $this->database->prepareAndExecuteQuery($sql, [$idVehicule]);
    }

    public function exists(string $immatriculation, int $idVehicule = null)
    {
        $sql = 'SELECT * FROM vehicule WHERE immatriculation = ?';
        $params = [$immatriculation];

        if (!is_null($idVehicule)) {
            $sql .= ' AND id_vehicule != ?';
            $params[] = $idVehicule;
        }

        return $this->database->selectOne($sql, $params);
    }

    public function count()
    {
        $sql = 'SELECT COUNT(*) FROM vehicule';

        return $this->database->prepareAndExecuteQuery($sql)->fetchColumn();
    }

    public function getVehiculesSansConducteur()
    {
        // https://sql.sh/2401-sql-join-infographie
        $sql = 'SELECT V.id_vehicule, marque, modele, couleur, immatriculation
                FROM vehicule AS V
                LEFT JOIN association_vehicule_conducteur AS A ON V.id_vehicule = A.id_vehicule
                WHERE A.id_conducteur IS NULL';

        return $this->database->selectAll($sql);
    }

    public function getVehiculesByConducteur(string $prenom, string $nom)
    {
        $sql = 'SELECT V.id_vehicule, marque, modele, couleur, immatriculation
                FROM vehicule AS V
                INNER JOIN association_vehicule_conducteur AS A ON A.id_vehicule = V.id_vehicule
                INNER JOIN conducteur AS C ON A.id_conducteur = C.id_conducteur
                WHERE C.prenom = ? AND C.nom = ?';

        return $this->database->selectAll($sql, [$prenom, $nom]);
    }
}