CREATE TABLE Amigos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(50),
    cumpleanios DATE,
    telefono VARCHAR(15) NOT NULL,
    dir_foto VARCHAR(50)
)