# Abonnement à la lettre d'information
## Besoins
Le principe général est de réaliser un ***formulaire d'inscription*** à une ***lettre d'information***. 

Ce formulaire permettra de recueillir l'adresse ***mail*** de l'internaute. Celle-ci sera alors enregistrée dans un ***fichier au format CSV***.

### Remarques :

- Lorsqu'on s'abonne un message nous avertit que l'opération s'est déroulée avec succès
- Si le champ email est vide ou bien si le format de l'adresse mail n'est pas correct, un message d'erreur le signale à l'internaute
- Si l'internaute est déjà abonné, il ne doit pas être abonné une seconde fois, un message lui signale également
- Si l'internaute soumet le formulaire plusieurs fois en rechargeant la page, il ne doit pas être abonné plusieurs fois 

## Objectifs pédagogiques

- transmettre des données grâce à un **formulaire**
- transmettre des données dans l'**URL**
- récupérer les données transmises lors d'une requête HTTP en PHP, avec la méthode GET ou POST
- Pattern ***Post-redirect-Get*** pour rediriger l'internaute après avoir posté des données
- ***Rediriger l'internaute*** en PHP
- La ***validation de formulaire*** : vérifier que les données sont transmises et qu'elles sont cohérentes
- Découvrir un aspect de la ***gestion des fichiers*** en PHP et le format ***CSV***

## Précisions techniques
### Le format CSV
Le format CSV est un format de données universel très utilisé, au même titre que le XML ou le JSON.
CSV signifie 'Coma separeted values' : dans un fichier CSV chaque ligne représente un élément. Et chaque information sur un élément est séparé par une virgule.

Par exemple le fichier suivant stocke des personnes :

    'Jean-Pierre','DUPONT',34
    'Marie-Christine','BOULANGER',28
    'Sylvie','DURAND',76
    
Ce format est compatible avec les logiciels de tableurs. 

### Gestion des fichiers en PHP
Il existe de nombreuses fonctions relatives à la gestion des fichiers en PHP. Nous allons principalement 
avoir besoin de fonctions pour :

- ouvrir un fichier
- lire dans un fichier au format CSV
- écrire dans un fichier au format CSV
- fermer un fichier

Comme toujours il existe de nombreuses stratégies différentes pour arriver à ses fins. 

### Conseils

Nous allons développer les bonnes pratiques suivantes :

- ***séparation des langages*** : les traitements PHP dans un fichier .php, le template avec le code HTML dans un fichier .phtml
- ***découpage du code en fonctions*** : il est très avantageux de découper son code en fonctions, soit pour éviter de se répéter, soit pour structurer le code, soit les deux. Nous mettrons nos
fonctions dans un fichier à part. 
- ***déclaration de constantes*** : toutes les données qui peuvent soit être répétées, soit changer, etc pourront être définies dans des constantes (messages d'erreur, nom du fichier CSV, etc)

## Mockups

![Capture 1](.resources/img/capture-1.png)
![Capture 2](.resources/img/capture-2.png)