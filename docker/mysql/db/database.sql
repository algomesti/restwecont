DROP DATABASE IF EXISTS restwecont;
CREATE DATABASE restwecont;

USE restwecont;

CREATE TABLE `users` (
  `userId` int UNSIGNED NOT NULL COMMENT 'Chave primaria da tabela',
  `name` varchar(255) NOT NULL COMMENT 'Nome do usuario',
  `email` varchar(255) NOT NULL COMMENT 'Email do usuario',
  `password` varchar(255) NOT NULL COMMENT 'Senha do usuario',
  `token` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Token de acesso',
  `refreshToken` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Token de refresh',
  `situation` enum('active','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active' COMMENT 'Situação do usuario',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '	Data de criacao do registro',
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '	Data alteracao do registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tabela de usuarios';


INSERT INTO `users` (`userId`, `name`, `email`, `password`, `token`, `refreshToken`, `situation`, `created`, `updated`) VALUES
(2, 'usuario 01', 'usuario01@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dC9YRkU1bTMyaHpXR0c4MA$N0aiJ5fGTMIEuzbBSegKR5/4mete+lhjgCKJWrPStzs', '', NULL, 'active', '2020-09-28 01:19:14', '2020-09-28 01:19:14');


ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email_unique` (`email`);

ALTER TABLE `users`
  MODIFY `userId` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela', AUTO_INCREMENT=3;
COMMIT;

CREATE TABLE `invoices` (
  `invoiceId` int NOT NULL COMMENT 'Chave primaria da tabela',
  `userId` int NOT NULL COMMENT 'Chave estrangeira da tabela user',
  `status` enum('Paga','Aberta','Atrasada','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Status da fatura',
  `expiration` date NOT NULL COMMENT 'Data de vencimento da fatura',
  `url` varchar(255) NOT NULL,
  `situation` enum('active','removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active' COMMENT 'Situação da fatura',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de criacao do registro',
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data alteracao do registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tabela de faturas';


ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoiceId`);

ALTER TABLE `invoices`
  MODIFY `invoiceId` int NOT NULL AUTO_INCREMENT COMMENT 'Chave primaria da tabela';
COMMIT;
