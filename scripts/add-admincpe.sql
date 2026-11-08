-- Creates the demo account or updates its original demo password.
UPDATE `tb_users`
SET `i_usr_pwd` = '$2y$10$7XLVCLlFUFgjPwFhJN/X8uAFB/mX1f39r.MRHjr91vqG8A.0Aancm'
WHERE `i_usr_uname` = 'admincpe';

INSERT INTO `tb_users` (`i_usr_uname`, `i_usr_pwd`)
SELECT 'admincpe', '$2y$10$7XLVCLlFUFgjPwFhJN/X8uAFB/mX1f39r.MRHjr91vqG8A.0Aancm'
WHERE NOT EXISTS (
  SELECT 1 FROM `tb_users` WHERE `i_usr_uname` = 'admincpe'
);
