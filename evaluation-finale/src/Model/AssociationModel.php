<?php

namespace App\Model;

use App\Core\AbstractModel;

class AssociationModel extends AbstractModel
{
    public function getAll()
    {
        $sql = 'SELECT id_association, A.id_vehicule, A.id_conducteur, prenom, nom, marque, modele
                FROM association_vehicule_conducteur AS A
                INNER JOIN conducteur AS C ON A.id_conducteur = C.id_conducteur
                INNER JOIN vehicule AS V ON A.id_vehicule = V.id_vehicule';

        return $this->database->selectAll($sql);
    }

    public function getOne(int $idAssociation)
    {
        $sql = 'SELECT id_association, A.id_vehicule, A.id_conducteur, prenom, nom, marque, modele
                FROM association_vehicule_conducteur AS A
                INNER JOIN conducteur AS C ON A.id_conducteur = C.id_conducteur
                INNER JOIN vehicule AS V ON A.id_vehicule = V.id_vehicule
                WHERE id_association = ?';

        return $this->database->selectOne($sql, [$idAssociation]);
    }

    public function insert(int $idConducteur, int $idVehicule)
    {
        $sql = 'INSERT INTO association_vehicule_conducteur (id_conducteur, id_vehicule)
                VALUES (?,?)';

        $this->database->prepareAndExecuteQuery($sql, [$idConducteur, $idVehicule]);
    }

    public function update(int $idConducteur, int $idVehicule, int $idAssociation)
    {
        $sql = 'UPDATE association_vehicule_conducteur SET id_conducteur = ?, id_vehicule = ? WHERE id_association = ?';

        $this->database->prepareAndExecuteQuery($sql, [$idConducteur, $idVehicule, $idAssociation]);
    }

    public function delete(int $idAssociation)
    {
        $sql = 'DELETE FROM association_vehicule_conducteur WHERE id_association = ?';

        $this->database->prepareAndExecuteQuery($sql, [$idAssociation]);
    }

    public function exists(int $idConducteur, int $idVehicule, int $idAssociation = null)
    {
        $sql = 'SELECT * FROM association_vehicule_conducteur WHERE id_conducteur = ? AND id_vehicule = ?';
        $params = [$idConducteur, $idVehicule];

        if (!is_null($idAssociation)) {
            $sql .= ' AND id_association != ?';
            $params[] = $idAssociation;
        }

        return $this->database->selectOne($sql, $params);
    }

    public function count()
    {
        $sql = 'SELECT COUNT(*) FROM association_vehicule_conducteur';

        return $this->database->prepareAndExecuteQuery($sql)->fetchColumn();
    }
}