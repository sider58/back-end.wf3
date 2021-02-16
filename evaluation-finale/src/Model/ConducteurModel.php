<?php

namespace App\Model;

use App\Core\AbstractModel;

class ConducteurModel extends AbstractModel
{
    public function getAll()
    {
        $sql = 'SELECT id_conducteur, prenom, nom
                FROM conducteur
                ORDER BY nom, prenom';

        return $this->database->selectAll($sql);
    }

    public function getOne(int $idConducteur)
    {
        $sql = 'SELECT id_conducteur, prenom, nom
                FROM conducteur
                WHERE id_conducteur = ?';

        return $this->database->selectOne($sql, [$idConducteur]);
    }

    public function insert(string $prenom, string $nom)
    {
        $sql = 'INSERT INTO conducteur (prenom, nom)
                VALUES (?,?)';

        $this->database->prepareAndExecuteQuery($sql, [$prenom, $nom]);
    }

    public function update(string $prenom, string $nom, int $idConducteur)
    {
        $sql = 'UPDATE conducteur SET prenom = ?, nom = ? WHERE id_conducteur = ?';

        $this->database->prepareAndExecuteQuery($sql, [$prenom, $nom, $idConducteur]);
    }

    public function delete(int $idConducteur)
    {
        $sql = 'DELETE FROM conducteur WHERE id_conducteur = ?';

        $this->database->prepareAndExecuteQuery($sql, [$idConducteur]);
    }

    public function exists(string $prenom, string $nom, int $idConducteur = null)
    {
        $sql = 'SELECT * FROM conducteur WHERE prenom = ? AND nom = ?';
        $params = [$prenom, $nom];

        if (!is_null($idConducteur)) {
            $sql .= ' AND id_conducteur != ?';
            $params[] = $idConducteur;
        }

        return $this->database->selectOne($sql, $params);
    }

    public function count()
    {
        $sql = 'SELECT COUNT(*) FROM conducteur';

        return $this->database->prepareAndExecuteQuery($sql)->fetchColumn();
    }

    public function getConducteursSansVehicules()
    {
        // https://sql.sh/2401-sql-join-infographie
        $sql = 'SELECT C.id_conducteur, prenom, nom
                FROM conducteur AS C
                LEFT JOIN association_vehicule_conducteur AS A ON C.id_conducteur = A.id_conducteur
                WHERE A.id_vehicule IS NULL';

        return $this->database->selectAll($sql);
    }

    public function getAllWithVehicules()
    {
        $sql = 'SELECT C.prenom, V.modele
                FROM conducteur AS C
                LEFT JOIN association_vehicule_conducteur AS A ON C.id_conducteur = A.id_conducteur
                LEFT JOIN vehicule AS V ON V.id_vehicule = A.id_vehicule';

        return $this->database->selectAll($sql);
    }

    public function getAllWithAllVehicules()
    {
        $sql = 'SELECT C.prenom, V.modele
                FROM conducteur AS C
                RIGHT JOIN association_vehicule_conducteur AS A ON C.id_conducteur = A.id_conducteur
                RIGHT JOIN vehicule AS V ON V.id_vehicule = A.id_vehicule';

        return $this->database->selectAll($sql);
    }

    public function getAllConducteursAndAllVehicules()
    {
        $sql = 'SELECT C.prenom, V.modele
                FROM conducteur AS C
                LEFT JOIN association_vehicule_conducteur AS A ON C.id_conducteur = A.id_conducteur
                LEFT JOIN vehicule AS V ON V.id_vehicule = A.id_vehicule
                UNION 
                SELECT C.prenom, V.modele
                FROM conducteur AS C
                RIGHT JOIN association_vehicule_conducteur AS A ON C.id_conducteur = A.id_conducteur
                RIGHT JOIN vehicule AS V ON V.id_vehicule = A.id_vehicule';

        return $this->database->selectAll($sql);
    }
}