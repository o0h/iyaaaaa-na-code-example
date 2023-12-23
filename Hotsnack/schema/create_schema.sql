BEGIN TRANSACTION;

CREATE TABLE IF NOT EXISTS user (
                                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                                    name TEXT NOT NULL,
                                    email TEXT UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS hotsnack (
                                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                                        name TEXT NOT NULL,
                                        description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS vote (
                                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                                    user_id INTEGER,
                                    hotsnack_id INTEGER,
                                    FOREIGN KEY(user_id) REFERENCES user(id),
    FOREIGN KEY(hotsnack_id) REFERENCES hotsnack(id)
    );

COMMIT;