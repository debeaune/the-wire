CREATE TABLE IF NOT EXISTS articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titre TEXT NOT NULL,
    auteur TEXT NOT NULL,
    sousTitre TEXT,
    contenu TEXT NOT NULL,
    image TEXT,
    source TEXT,
    url TEXT NOT NULL,
    datePublication TEXT NOT NULL,
    categorie TEXT
);

CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    contenu TEXT NOT NULL,
    date TEXT NOT NULL,
    articleId INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    auteur TEXT NOT NULL,
    contenu TEXT NOT NULL,
    datePublication TEXT NOT NULL,
    langue TEXT NOT NULL
);