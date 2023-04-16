CREATE TABLE Pais (
    nombre varchar(100) PRIMARY KEY
);

CREATE TABLE Imagen (
    enlace VARCHAR(150) PRIMARY KEY,
    descripcion VARCHAR(100)
);

CREATE TABLE Cientifico (
    nombre VARCHAR(100),
    fechaNacimiento DATE NOT NULL,
    fechaDefuncion DATE NOT NULL,
    lugarOrigen VARCHAR(100) NOT NULL,
    biografia TEXT NOT NULL,
    portada VARCHAR(150) DEFAULT 'default.png', -- Enlace a la foto

    PRIMARY KEY (nombre),
    CONSTRAINT VALORES_FECHAS CHECK(fechaNacimiento < fechaDefuncion),
    FOREIGN KEY (lugarOrigen) REFERENCES Pais(nombre),
    FOREIGN KEY (portada) REFERENCES Imagen(enlace)
);

-- Relacion Cientifico-Imagen para las fotos de la biografía (excluye las de la portada)
CREATE TABLE ImagenBiografia (
    cientifico VARCHAR(100) NOT NULL,
    enlace VARCHAR(150) NOT NULL UNIQUE,
    FOREIGN KEY (cientifico) REFERENCES Cientifico(nombre),
    FOREIGN KEY (enlace) REFERENCES Imagen(enlace)
);

-- TODO: Comentarios
-- ? Como consideraremos a los usuarios ?