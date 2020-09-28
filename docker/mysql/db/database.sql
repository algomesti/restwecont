DROP DATABASE IF EXISTS restwecont;
CREATE DATABASE restwecont;

CREATE TABLE `restwecont`.`invoices` (
  `invoiceId` int NOT NULL COMMENT 'Chave primaria da tabela',
  `userId` int NOT NULL COMMENT 'Chave estrangeira da tabela user',
  `status` enum('Paga','Aberta','Atrasada','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Status da fatura',
  `expiration` date NOT NULL COMMENT 'Data de vencimento da fatura',
  `url` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criacao do registro',
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data alteracao do registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tabela de faturas';

CREATE TABLE `restwecont`.`users` (
  `userId` int UNSIGNED NOT NULL COMMENT 'Chave primaria da tabela',
  `name` varchar(255) NOT NULL COMMENT 'Nome do usuario',
  `email` varchar(255) NOT NULL COMMENT 'Email do usuario',
  `password` varchar(255) NOT NULL COMMENT 'Senha do usuario',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '	Data de criacao do registro',
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '	Data alteracao do registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tabela de usuarios';

ALTER TABLE `restwecont`.`invoices`
  ADD PRIMARY KEY (`invoiceId`);

ALTER TABLE `restwecont`.`users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email_unique` (`email`);

ALTER TABLE `restwecont`.`invoices`
  MODIFY `invoiceId` int NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela';

ALTER TABLE `restwecont`.`users`
  MODIFY `userId` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela', AUTO_INCREMENT=2;
