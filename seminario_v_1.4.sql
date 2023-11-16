-- Database: seminario


-- DROP DATABASE IF EXISTS seminario;

-- CREATE DATABASE if not exists seminario
--     WITH
--     OWNER = postgres
--     ENCODING = 'UTF8'
--     LC_COLLATE = 'Portuguese_Brazil.1252'
--     LC_CTYPE = 'Portuguese_Brazil.1252'
--     TABLESPACE = pg_default
--     CONNECTION LIMIT = -1
--     IS_TEMPLATE = False;



-- CREATE database seminario;

	
CREATE OR REPLACE FUNCTION gerar_num_random_user()
RETURNS INTEGER AS $$
DECLARE
    num_random_mat INTEGER[];
    i INTEGER;
    new_num_mat INTEGER;
BEGIN
    num_random_mat := array(SELECT matricula_usuario FROM usuario);

    LOOP
        new_num_mat := floor(random() * (21299999 - 21200000 + 1)) + 21200000;
        IF new_num_mat = ANY(num_random_mat) THEN
            CONTINUE;
        ELSE
            RETURN new_num_mat;
        END IF;
    END LOOP;

    -- Retornar -1 se não for possível gerar um número único
    RETURN -1;
END;
$$ LANGUAGE plpgsql;
--#############(tabela usuario e funções)

-- DROP FUNCTION gerar_num_random;

--#############(tabela curso e funções)	

create table if not exists cursos(
	"codigo" int primary key not null,
	"nome" varchar(40),
	"duracao" int --mudar no banco
);

INSERT INTO cursos (codigo, nome, duracao)
VALUES
  (401, 'Administração', 4),
  (402, 'Direito', 5),
  (403, 'Enfermagem', 4),
  (404, 'Estética e Cosmética', 3),
  (405, 'Fisioterapia', 4),
  (406, 'Gastronomia', 2),
  (407, 'Gestão de RH', 4),
  (408, 'Logística', 4),
  (409, 'Nutrição', 4),
  (410, 'Sistemas de Informação', 4);

--Função ativada para codigo de curso através de um gatilho

select * from cursos;

CREATE OR REPLACE FUNCTION set_codigo_on_insert()
RETURNS TRIGGER AS $$
BEGIN
    NEW.codigo = 
        CASE 
            WHEN NEW.nome = 'Administração' THEN 401
            WHEN NEW.nome = 'Direito' THEN 402
            WHEN NEW.nome = 'Enfermagem' THEN 403
            WHEN NEW.nome = 'Estética e Cosmética' THEN 404
            WHEN NEW.nome = 'Fisioterapia' THEN 405
            WHEN NEW.nome = 'Gastronomia' THEN 406
            WHEN NEW.nome = 'Gestão de RH' THEN 407
            WHEN NEW.nome = 'Logística' THEN 408
            WHEN NEW.nome = 'Nutrição' THEN 409
            WHEN NEW.nome = 'Sistemas de Informação' THEN 410
            ELSE NULL
        END;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_set_codigo
BEFORE INSERT ON cursos
FOR EACH ROW EXECUTE FUNCTION set_codigo_on_insert();

-- DROP table cursos;
--#############(tabela curso e funções)


create table if not exists professor(
	"id_professor_pk" serial primary key NOT NULL,
	"nome"  varchar(40), --mudar no diagrama
	"formacao" varchar(40) --mudar no diagrama
);

INSERT INTO professor (nome, formacao)
VALUES
    ('João Silva', 'Doutorado'),
    ('Maria Santos', 'Mestrado'),
    ('Pedro Costa', 'Especialização'),
    ('Ana Oliveira', 'Graduação'),
    ('Rafael Pereira', 'Doutorado'),
    ('Juliana Rodrigues', 'Mestrado'),
    ('Fernando Almeida', 'Especialização'),
    ('Carla Souza', 'Graduação'),
    ('Lucas Carvalho', 'Doutorado'),
    ('Laura Ferreira', 'Mestrado'),
    ('Diego Silva', 'Especialização'),
    ('Mariana Santos', 'Graduação'),
    ('Thiago Oliveira', 'Doutorado'),
    ('Beatriz Ramos', 'Mestrado'),
    ('Gustavo Costa', 'Especialização'),
    ('Isabela Pereira', 'Graduação'),
    ('Ricardo Almeida', 'Doutorado'),
    ('Larissa Silva', 'Mestrado'),
    ('André Santos', 'Especialização'),
    ('Camila Ferreira', 'Graduação');







create table if not exists disciplina(
	"id_disciplina_pk" serial primary key NOT NULL,	
	"codigo_curso_fk" int,   --mudar no diagrama
	"nome" varchar(40),
	"carga_horaria" int,	
	
	FOREIGN KEY(codigo_curso_fk) references cursos(codigo)
		
);

select * from disciplina;


INSERT INTO disciplina ( codigo_curso_fk, nome, carga_horaria)
VALUES
    (410, 'Matemática discreta', 80),   
    (410, 'Programação web', 80),
    (410, 'Inglês ', 40),
    (401, 'Economia Financeira', 40),    
    (409, 'Nutrição e Saúde', 40),     
    (401, 'Administração de Empresas', 80),       
    (410, 'Engenharia de software', 80),   
    (402, 'Direito Penal', 80);
	
select * from disciplina;

create table if not exists oferta (
	"id_oferta_pk" serial primary key not null,
	"id_disciplina_fk" int,
	"ano_letivo" varchar(30), -- mudar no diagrama
	"periodo" int,
	"id_professor_fk" int,
	
	FOREIGN KEY(id_professor_fk) references professor(id_professor_pk),
	FOREIGN KEY(id_disciplina_fk) references disciplina(id_disciplina_pK)
);

INSERT INTO oferta (id_disciplina_fk, ano_letivo, periodo)
VALUES
  (1, '2021', 1),
  (2, '2021', 2),
  (3, '2021', 3),
  (4, '2021', 4),
  (5, '2021', 5),
  (6, '2021', 6),
  (6, '2021', 1),
  (7, '2021', 2),
  (8, '2021', 4),
  (3, '2021', 7),
  (1, '2021', 8),
  (1, '2021', 5),
  (2, '2021', 3),
  (3, '2021', 8),
  (4, '2021', 2),
  (5, '2021', 3),
  (6, '2021', 6),
  (7, '2021', 3),
  (8, '2021', 1),
  (4, '2021', 2);




	
create table if not exists categoria (
	"id_categoria" serial primary key not null,
	"categoria" varchar(60)
);

INSERT INTO categoria (categoria) VALUES
('Resumo'),
('Resenha'),
('Relatório'),
('Artigo'),
('TCC'),
('Monografia'),
('Dissertação'),
('Tese'),
('Projeto de pesquisa'),
('Seminário temático'),
('Atividade de fixação'),
('TDE');


create table if not exists competencias (
	"id_competencias" serial primary key not null,
	"competencias" varchar(60)
);

INSERT INTO competencias (competencias) VALUES
('Pensamento crítico'),
('Resolução de problemas complexos'),
('Criatividade'),
('Originalidade e iniciativa'),
('Liderança e influência social'),
('Pensamento analítico'),
('Resiliência'),
('Tolerância e flexibilidade'),
('Inteligência emocional'),
('Comunicação assertiva e eficiente'),
('Aprendizado contínuo'),
('Digital skills'),
('Relacionamento interpessoal'),
('Aptidão para inovação'),
('Foco em resultados'),
('Comprometimento'),
('Proatividade e automotivação'),
('Administração'),
('Arquitetura'),
('Artesanato'),
('Ciência da Computação');



create table if not exists usuario(
	"id_usuario_pk" serial primary key NOT NULL, 
	
	"matricula_usuario" int unique DEFAULT gerar_num_random_user(),
	"codigo_curso_fk" int not null,
	"nome_usuario" varchar(70),
	"cpf" varchar(20) unique NOT NULL,
	"sexo" varchar(10),
	"telefone" varchar(20) unique NOT NULL,
	"endereco" varchar(255),
	"uf" varchar(10),
	"cidade" varchar(100),
	"data_nascimento" date NOT NULL,
	"email" varchar(255) unique NOT NULL,
	"senha" varchar(70) NOT NULL,
	
	FOREIGN KEY (codigo_curso_fk) REFERENCES cursos(codigo)
    );
	
	CREATE TABLE IF NOT EXISTS trabalhos(
	"id_tabalho_pk" serial primary key NOT NULL, --mudar no diagrama
	"nome" varchar(70), --mudar no diagrama
	"data_inicio" date NOT NULL,
	"data_final" date NOT NULL,
	"quantidade_pessoas" int,
	"feedback_aluno" varchar(2000), --mudar no diagrama
		
	"competencias_fk" int,
	"categoria_fk" int,
	"id_oferta_fk" int,
		
	"matricula_usuario_fk" int,
	"anexo_atividade" varchar(1000),	
	"decricao" varchar(2000),

	FOREIGN KEY(competencias_fk) references competencias(id_competencias),
	FOREIGN KEY(categoria_fk) references categoria(id_categoria),
	FOREIGN KEY(id_oferta_fk) references oferta(id_oferta_pk),
	FOREIGN KEY(matricula_usuario_fk) references usuario(matricula_usuario)
);
	

	
select * from oferta;
select * from usuario;
select * from cursos;

select usuario.id_usuario_pk, trabalhos.data_inicio from usuario join trabalhos on usuario.id_usuario_pk = trabalhos.id_tabalho_pk ;