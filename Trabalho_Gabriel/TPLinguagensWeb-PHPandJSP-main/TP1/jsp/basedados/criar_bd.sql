CREATE DATABASE IF NOT EXISTS gestao_cursos;

USE gestao_cursos;

CREATE TABLE utilizadores (
	id_utilizador INT AUTO_INCREMENT PRIMARY KEY,
	nome TEXT NOT NULL,
	ultimo_nome TEXT NOT NULL,
	e_mail TEXT NOT NULL UNIQUE,
	user_name TEXT NOT NULL UNIQUE,
	password TEXT NOT NULL,
	perfil TEXT NOT NULL,
	autenticado BOOLEAN DEFAULT false
);


CREATE TABLE cursos (
	id_curso INT AUTO_INCREMENT PRIMARY KEY,
	id_utilizador INT,
	nome_curso TEXT NOT NULL,
	descricao TEXT,
	preco DECIMAL(10,2) NOT NULL CHECK(preco >=0),
	vagas_disponiveis INT NOT NULL CHECK(vagas_disponiveis >=0),
	vagas_totais INT NOT NULL CHECK(vagas_totais >0),
	FOREIGN KEY (id_utilizador) REFERENCES utilizadores (id_utilizador)
);


CREATE TABLE inscricoes (
	id_inscricao INT AUTO_INCREMENT PRIMARY KEY,
	id_utilizador INT,
	id_curso INT,
	data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (id_utilizador) REFERENCES utilizadores (id_utilizador),
	FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil,autenticado)
VALUES(
	"nome",
	"ultimo_nome",
	"aluno@aluno.com",
	"aluno",
	MD5("aluno"),
	"aluno",
	true
);

INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil,autenticado)
VALUES(
	"nome",
	"ultimo_nome",
	"docente@docente.com",
	"docente",
	MD5("docente"),
	"docente",
	true
);
INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil,autenticado)
VALUES(
	"nome",
	"ultimo_nome",
	"admin@admin.com",
	"admin",
	MD5("admin"),
	"admin",
	true
);

INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil)
VALUES(
	"Gabriel",
	"Pereira",
	"g.p1@iocbcampus.pt",
	"gabriel",
	MD5("gabriel"),
	"aluno"
);
INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil)
VALUES(
	"Isabel",
	"Patricio",
	"i.patricio@ipcbcampus.pt",
	"isabel",
	MD5("isabel"),
	"aluno"
);

INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil)
VALUES(
	"Carlos",
	"Alves",
	"cmoa@ipcbcampus.pt",
	"cmoa",
	MD5("cmoa"),
	"docente"
);

INSERT INTO cursos (id_utilizador, nome_curso, descricao, preco, vagas_disponiveis, vagas_totais)
VALUES
(2, 'Curso de Programação', 'Aprenda a programar em diversas linguagens', 99, 30, 30),
(2, 'Curso de Design Gráfico', 'Domine as técnicas de design e criação visual', 149, 25, 25);
