<?php

// Inclusion du fichier de configuration
require '../config.php';

/**
 * Crée la connexion PDO
 */
function getPDOConnection()
{
    // Construction du Data Source Name
    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    return $pdo;
}

/**
 * Prépare et exécute une requête SQL
 */
function prepareAndExecuteQuery(string $sql, array $criteria = []): PDOStatement
{
    // Connexion PDO
    $pdo = getPDOConnection();

    // Préparation de la requête SQL
    $query = $pdo->prepare($sql);

    // Exécution de la requête
    $query->execute($criteria);

    // Retour du résultat
    return $query;
}

/**
 * Exécute une requête de sélection et retourne plusieurs résultats
 */
function selectAll(string $sql, array $criteria = [])
{
    $query = prepareAndExecuteQuery($sql, $criteria);

    return $query->fetchAll();
}


/**
 * Exécute une requête de sélection et retourne UN résultat
 */
function selectOne(string $sql, array $criteria = [])
{
    $query = prepareAndExecuteQuery($sql, $criteria);

    return $query->fetch();
}

/**
 * Récupère tous les produits
 */
function getAllProducts()
{
    $sql = 'SELECT P.id AS product_id, name, price, stock, picture, label, shop_name
            FROM products AS P
            INNER JOIN categories AS Ca ON Ca.id = P.category_id
            INNER JOIN creators AS Cr ON Cr.id = P.creator_id
            LIMIT 0, 5';

    return selectAll($sql);
}

/**
 * Récupère un produit à partir de son id
 */
function getProductById(int $id)
{
    /**
     * La requête sans les alias
     * 
     * $sql = 'SELECT products.id AS product_id, name, price, stock, picture, label, shop_name, description
     *       FROM products
     *       INNER JOIN categories ON categories.id = products.category_id
     *       INNER JOIN creators ON creators.id = products.creator_id
     *       WHERE products.id = ?';
     */

    $sql = 'SELECT P.id AS product_id, name, price, stock, picture, label, shop_name, description, P.category_id, P.creator_id
            FROM products AS P
            INNER JOIN categories AS Ca ON Ca.id = P.category_id
            INNER JOIN creators AS Cr ON Cr.id = P.creator_id
            WHERE P.id = ?';

    return selectOne($sql, [$id]);
}

function removeProduct(int $productId)
{
    $sql = 'DELETE FROM products
            WHERE id = ?';

    prepareAndExecuteQuery($sql, [$productId]);
}

/**
 * Insert un commentaire dans la table comments
 */
function insertComment(string $content, int $productId, int $userId)
{
    $sql = 'INSERT INTO comments (content, createdAt, product_id, user_id)
            VALUES (?, NOW(), ?, ?)';

    prepareAndExecuteQuery($sql, [$content, $productId, $userId]);
}

function getAllComments(bool $validated = true)
{
    $sql = 'SELECT content, C.createdAt, firstname, lastname, validated, name AS product_name
            FROM comments AS C
            INNER JOIN users AS U ON C.user_id = U.id
            INNER JOIN products AS P on P.id = C.product_id';

    /**
     * Si le paramètre $validated vaut true, on ajoute une condition à la clause
     * WHERE pour filtrer les commentaires validés
     */
    if ($validated) {
        $sql .= ' WHERE validated = 1';
    }

    $sql .= ' ORDER BY C.validated DESC, C.createdAt DESC';

    return selectAll($sql);
}


function getCommentsByProductId(int $productId, bool $validated = true)
{
    $sql = 'SELECT content, C.createdAt, firstname, lastname
            FROM comments AS C
            INNER JOIN users AS U ON C.user_id = U.id
            WHERE product_id = ?';

    /**
     * Si le paramètre $validated vaut true, on ajoute une condition à la clause
     * WHERE pour filtrer les commentaires validés
     */
    if ($validated) {
        $sql .= ' AND validated = 1';
        // $sql = $sql . ' AND validated = 1';
    }

    $sql .= ' ORDER BY C.createdAt DESC';

    return selectAll($sql, [$productId]);
}


function getAllCategories()
{
    $sql = 'SELECT id, label
            FROM categories
            ORDER BY label';

    return selectAll($sql);
}

function getAllCreators()
{
    $sql = 'SELECT id, shop_name
            FROM creators
            ORDER BY shop_name';

    return selectAll($sql);        
}


/**
 * Insère un nouvel utilisateur
 */
function insertUser(string $firstname, string $lastname, string $email, string $password, string $role)
{
    $sql = 'INSERT INTO users (firstname, lastname, email, password, createdAt, role)
            VALUES (?, ?, ?, ?, NOW(), ?)';

    // Hashage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    prepareAndExecuteQuery($sql, [$firstname, $lastname, $email, $hashedPassword, $role]);
}


function insertProduct(string $name, string  $description, float $price, int $stock, int $categoryId, int $creatorId, string $picture)
{
    $sql = 'INSERT INTO products (name, description, price, stock, category_id, creator_id, picture)
            VALUES (?, ?, ?, ?, ?, ?, ?)';

    prepareAndExecuteQuery($sql, [$name, $description, $price, $stock, $categoryId, $creatorId, $picture]);        
}


function updateProduct(int $productId, string $name, string  $description, float $price, int $stock, int $categoryId, int $creatorId, string $picture)
{
    $sql = 'UPDATE products
            SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, creator_id = ?, picture = ?
            WHERE id = ?';

    prepareAndExecuteQuery($sql, [$name, $description, $price, $stock, $categoryId, $creatorId, $picture, $productId]);        
}

/**
 * Sélectionne un utilisateur à partir de son email
 */
function getUserByEmail(string $email) 
{
    $sql = 'SELECT id, firstname, lastname, email, password, role 
            FROM users
            WHERE email = ?';

    return selectOne($sql, [$email]);
}

function validateUserForm(string $firstname, string $lastname, string $email, string $password, string $passwordConfirm)
{
    $errors = [];

    if (!$firstname) {
        $errors[] = 'Le champ "Prénom" est obligatoire';
    }

    if (!$lastname) {
        $errors[] = 'Le champ "Nom" est obligatoire';
    }

    if (!$email) {
        $errors[] = 'Le champ "Email" est obligatoire';
    }

    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Le champ "Email" est invalide';
    }

    if (getUserByEmail($email)) {
        $errors[] = 'Un compte existe déjà avec cet email';
    }

    if (!$password) {
        $errors[] = 'Le champ "Mot de passe" est obligatoire';
    }

    if ($password !== $passwordConfirm) {
        $errors[] = 'La confirmation du mot de passe est incorrecte';
    }

    if (mb_strlen($password) < 8) {
        $errors[] = 'Votre mot de passe doit comporter au moins 8 caractères';
    }

    return $errors;
}


function validateLoginForm(string $email, string $password): array
{
    $errors = [];
    
    if (!$email) {
        $errors[] = 'Le champ "Email" est obligatoire.';
    }

    if (!$password) {
        $errors[] = 'Le champ "Mot de passe" est obligatoire.';
    }

    return $errors;
}


function validateProductForm($name, $description, $price, $stock)
{
    $errors = [];

    if (!$name) {
        $errors[] = 'Le nom du produit est obligatoire';
    }

    if (!$description) {
        $errors[] = 'Le description du produit est obligatoire';
    }

    if (!$price) {
        $errors[] = 'Le prix du produit est obligatoire';
    }
    else if (!is_numeric($price) || $price < 0) {
        $errors[] = 'La valeur du prix est incorrecte';
    }

    if (!$stock) {
        $errors[] = 'Le stock du produit est obligatoire';
    }
    else if (!ctype_digit($stock) || $stock < 0) {
        $errors[] = 'La valeur du stock est incorrecte';
    }

    return $errors;
}

/**
 * Envoi en sortie le rendu d'un fichier de template
 */
function render(string $template, array $values = [], string $baseTemplate = 'base')
{
    // Extraction des variables
    extract($values);

    // Récupération du message flash le cas échéant
    $flashMessages = fetchAllFlashMessages();

    // Inclusion du template de base
    include '../templates/'.$baseTemplate.'.phtml';
}


function format_date($date)
{
    $objDate = new DateTime($date);
    return $objDate->format('d/m/Y');
}

/**
 * Formate un prix à la française xx,xx €
 */
function format_price(float $price): string 
{
    // return number_format($price, 2, ',', ' ') . ' €';
    $formatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($price, 'EUR');
}

/******************************
 * GESTION DES MESSAGES FLASH
 ******************************/

/**
 * Démarre la session (le cas échéant, si aucune session n'est déjà démarrée)
 * Initialise un tableau vide à la clé 'flashbag' si jamais la clé n'existe pas 
 * ou si elle ne contient pas de tableau
 */
function initFlashbag()
{
    // Si aucune session n'est encore démarrée ...
    if (session_status() === PHP_SESSION_NONE) {

        // ... alors on en démarre une
        session_start();
    } 

    // Si la clé 'flashbag' n'existe pas en session ou si elle n'est pas définie... 
    if (!array_key_exists('flashbag', $_SESSION) || !isset($_SESSION['flashbag'])) {

        // ... alors on range dans la clé 'flashbag' un tableau vide
        $_SESSION['flashbag'] = [];
    }
}

/**
 * Ajout un message flash au flashbag en session
 */
function addFlashMessage(string $message)
{
    // Initialisation du flashbag
    initFlashbag();

    // On ajoute dans le tableau de message le message passé en paramètre
    // $_SESSION['flashbag'][] = $message;
    array_push($_SESSION['flashbag'], $message);
}

/**
 * Récupère et retourne l'ensemble des messages flash de la session
 * Rem: une fois récupérés, les messages sont supprimés
 */
function fetchAllFlashMessages(): array 
{
    // Initialisation du flashbag
    initFlashbag();

    // On récupère tous les messages 
    $flashMessages = $_SESSION['flashbag'];

    // On supprime les messages de la session
    $_SESSION['flashbag'] = [];

    // On retourne le tableau de messages
    return $flashMessages;
}

/**
 * Détermine si il y a des messages flash en session
 */
function hasFlashMessages(): bool
{
    // Initialisation du flashbag
    initFlashbag();

    // Retourne true si il y a des messages dans le tableau, false sinon
    return !empty($_SESSION['flashbag']);
}


function verifyPassword(array $user, $password)
{
    /**
     * $user['password'] : mot de passe enregistré en base de données
     * $password : mot de passe rentré par l'utilisateur dans le formulaire de connexion
     */
    return password_verify($password, $user['password']);
}


function authenticate(string $email, string $password)
{
    // On va chercher l'utilisateur en fonction de son email
    $user = getUserByEmail($email);

    // Si on récupère bien un résultat (un utilisateur)
    if ($user) {

        // Vérification du mot de passe
        if (verifyPassword($user, $password)) {

            // On retourne les informations de l'utilisateur
            return $user;
        }
        else {
            return "Mot de passe incorrect";
        }
    }
    else {
       return "Ce compte n'existe pas"; 
    }
}

/**
 * Initialise la session si besoin
 */
function initSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Enregistre les données de l'utilisateur connecté en session
 */
function userSessionRegister(int $id, string $firstname, string $lastname, string $email, string $role)
{
    initSession();

    $_SESSION['user'] = [
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'role' => $role
    ];
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function isAuthenticated(): bool
{
    initSession();

    return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
}

/**
 * Déconnexion utilisateur
 */
function logout()
{
    if (isAuthenticated()) {

        // On efface les données qu'on avait enregistrées
        $_SESSION['user'] = null; // ou bien : unset($_SESSION['user])
        
        // On ferme la session
        session_destroy();
    }
}


function getUserFullname(): ?string
{
    // Si l'utilisateur n'est pas connecté
    if (!isAuthenticated()) {
        return null;
    }

    // S'il est connecté
    return $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
}


function getUserId(): ?int 
{
    // Si l'utilisateur n'est pas connecté
    if (!isAuthenticated()) {
        return null;
    }

    // S'il est connecté
    return $_SESSION['user']['id'];
}