-- Adds the demo account without duplicating it when this script is run again.
INSERT INTO `tb_users` (`i_usr_uname`, `i_usr_pwd`)
SELECT 'admincpe', '$2y$10$/cvHpJDUQNdxWLG2VsSKheAf2Yw8fpq3M2lohOd9oDqng3fgARrES'
WHERE NOT EXISTS (
  SELECT 1 FROM `tb_users` WHERE `i_usr_uname` = 'admincpe'
);
