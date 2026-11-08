const fs = require('node:fs');
const path = require('node:path');
const { spawn, spawnSync } = require('node:child_process');

const root = path.resolve(__dirname, '..');
const mampPhp = 'C:\\MAMP\\bin\\php\\php8.3.1\\php.exe';
const mampIni = 'C:\\MAMP\\conf\\php8.3.1\\php.ini';
const mampExt = 'C:\\MAMP\\bin\\php\\php8.3.1\\ext';
const phpBin = process.env.PHP_BIN || (fs.existsSync(mampPhp) ? mampPhp : 'php');
const phpIni = process.env.PHP_INI || '';
const phpArgs = phpIni
  ? ['-c', phpIni]
  : (phpBin === mampPhp && fs.existsSync(path.join(mampExt, 'php_pdo_mysql.dll'))
    ? ['-d', `extension_dir=${mampExt}`, '-d', 'extension=php_pdo_mysql.dll']
    : []);
const envFile = path.join(root, '.env');
if (fs.existsSync(envFile)) {
  for (const rawLine of fs.readFileSync(envFile, 'utf8').split(/\r?\n/)) {
    const line = rawLine.trim();
    if (!line || line.startsWith('#')) continue;
    const match = line.match(/^([A-Za-z_][A-Za-z0-9_]*)\s*=\s*(.*)$/);
    if (!match || process.env[match[1]] !== undefined) continue;
    let value = match[2].trim();
    if ((value.startsWith('"') && value.endsWith('"')) || (value.startsWith("'") && value.endsWith("'"))) {
      value = value.slice(1, -1);
    }
    process.env[match[1]] = value;
  }
}

const php = spawnSync(phpBin, [...phpArgs, '-v'], { cwd: root, encoding: 'utf8', env: process.env });
if (php.error || php.status !== 0) {
  console.error('PHP CLI was not found. Install PHP 8.1+ with PDO MySQL, add php.exe to PATH, or set PHP_BIN.');
  process.exit(1);
}
const modules = spawnSync(phpBin, [...phpArgs, '-m'], { cwd: root, encoding: 'utf8', env: process.env });
if (!/^pdo_mysql$/im.test(modules.stdout || '')) {
  console.error('PHP PDO MySQL extension is not enabled. Check your PHP_INI setting or enable pdo_mysql in php.ini.');
  process.exit(1);
}

const port = process.env.PORT || '8000';
console.log(`Northwind BMS local server: http://127.0.0.1:${port}`);
console.log('Stop the server with Ctrl+C. Make sure MySQL is running and dbNorthwind.sql is imported.');
const server = spawn(phpBin, [...phpArgs, '-S', `127.0.0.1:${port}`, 'scripts/router.php'], {
  cwd: root,
  env: process.env,
  stdio: 'inherit',
});
server.on('error', error => {
  console.error(`Could not start PHP: ${error.message}`);
  process.exitCode = 1;
});
server.on('exit', code => { process.exitCode = code ?? 0; });
for (const signal of ['SIGINT', 'SIGTERM']) {
  process.on(signal, () => server.kill(signal));
}
